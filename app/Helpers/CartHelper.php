<?php

namespace App\Helpers;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Product;
use App\Models\ProductVariation;
use App\Models\Order;
use App\Models\OrderAddress;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Cache;

class CartHelper
{
    public static function disk()
    {
        return (Auth::check()) ? 'database' : 'session';
    }

    public static function saveQuantity($product_id, $product_variation_id, $quantity)
    {
        $disk = self::disk();

        $user_id = (Auth::check()) ? Auth::user()->id : 'session';

        if ($disk == 'database') { // Save to database
            if ($quantity > 0) {
                Cart::updateOrCreate(
                    [
                        'user_id' => $user_id,
                        'product_id' => $product_id,
                        'product_variation_id' => $product_variation_id
                    ],
                    ['quantity' => $quantity]
                );
            } else {
                Cart::where('user_id', $user_id)
                    ->where('product_id', $product_id)
                    ->where('product_variation_id', $product_variation_id)
                    ->delete();
            }
        } else { // Save to session
            $cart = CartHelper::items();

            $product_key = self::generateKey($product_id, $product_variation_id);

            if ($quantity > 0) {
                $cart[$product_key] = [
                    'quantity' => $quantity,
                    'product_id' => $product_id,
                    'product_variation_id' => $product_variation_id,
                ];
            } else {
                unset($cart[$product_key]);
            }

            Session::put('cart', $cart);
        }

        Cache::forget(Auth::check() ? 'cart_total_' . Auth::id() : 'cart_total_guest_' . session()->getId());
    }

    public static function items()
    {
        $user_id = (Auth::check()) ? Auth::user()->id : 'session';
        
        $cart_items = [];

        if (self::disk() == 'database') {

            $db_cart  = Cart::where('user_id', $user_id)->get();

            $cart_items = [];

            foreach ($db_cart as $db_cart_item) {

                $product_key = self::generateKey($db_cart_item->product_id, $db_cart_item->product_variation_id);

                $is_product_variant = (!empty($db_cart_item->product_variation_id));

                $product = $db_cart_item->product;

                $product_variation = ($is_product_variant) ? ProductVariation::withTrashed()->where('id', $db_cart_item->product_variation_id)->select('name', 'price', 'product_id')->first() : null;

                $price = ($is_product_variant) ? ($product_variation->discountedPriceWithCurrency() ?? 0) : ($product->discountedPriceWithCurrency() ?? 0);
                
                $cart_items[$product_key] = [
                    'product_id' => $product->id,
                    'product_variation_id' => $db_cart_item->product_variation_id,
                    'product_name' => $product->name,
                    'product_variation_name' => $product_variation->name ?? '',
                    'product_price' => $price,
                    'product_picture' => $product->display_image_url,
                    'quantity' => $db_cart_item->quantity
                ];
            }

            return $cart_items;

        } else {

            $cart_items = Session::get('cart', []);

            foreach ($cart_items as &$item) {
                $product = Product::where('id', $item['product_id'])->first();
                if ($product) {
                    $item['product_name'] = $product->name;
                    $item['product_price'] = ($product->discountedPriceWithCurrency() ?? 0);
                    $item['product_picture'] = $product->display_image_url;
                }

                if (!empty($item['product_variation_id'])) {

                    $product_variation = ProductVariation::withTrashed()->where('id', $item['product_variation_id'])->select('name', 'price', 'product_id')->first();

                    if ($product)
                        $item['product_variation_name'] = $product_variation->name;

                    $item['product_price'] = ($product_variation->discountedPriceWithCurrency() ?? 0);
                }
            }

            return $cart_items;
        }
    }

    public static function itemCount()
    {
        if (self::disk() === 'database') {
            return Cart::where('user_id', Auth::id())->count(); // Just count the distinct rows (each row is a unique item)
        } else {
            $cart = Session::get('cart', []);
            return count($cart);
        }
    }

    public static function removeItem($product_id, $product_variation_id)
    {
        self::saveQuantity($product_id, $product_variation_id, 0);
    }

    public static function total()
    {
        if (self::disk() === 'database') {

            $cache_key = Auth::check() ? 'cart_total_' . Auth::id() : 'cart_total_guest_' . session()->getId();

            return cache()->rememberForever($cache_key, function() {
                $cart_items = self::items();
                return array_reduce($cart_items, function($total, $item) {
                    return $total + (($item['quantity'] ?? 0) * ($item['product_price'] ?? 0));
                }, 0);
            });

        }else{

            $cart_items = self::items();
            return array_reduce($cart_items, function($total, $item) {
                return $total + (($item['quantity'] ?? 0) * ($item['product_price'] ?? 0));
            }, 0);
        }
    }

    public static function syncToDatabse($user_id = null)
    {
        $user_id =  (!empty($user_id)) ? $user_id : Auth::user()->id;

        $cart_items = Session::get('cart', []);

        // dd($cart_items);

        foreach ($cart_items as $cart_key => $value) {

            list($product_id, $product_variation_id) = self::parseKey($cart_key);

            if (empty($product_variation_id))
                $cart_product = Cart::where('product_id', $product_id)->where('user_id', $user_id)->first();
            else
                $cart_product = Cart::where('product_id', $product_id)->where('product_variation_id', $product_variation_id)->where('user_id', $user_id)->first();

            $quantity = $value['quantity'];

            if (!empty($cart_product)) {
                $quantity = $quantity + $cart_product->quantity;
            } else {
                $cart_product = new Cart();
            }

            $cart_product->user_id = $user_id;
            $cart_product->product_id = $product_id;
            $cart_product->product_variation_id = $product_variation_id;
            $cart_product->quantity = $quantity;
            $cart_product->save();
        }

        Session::forget('cart');
    }

    public static function getQuantity($product_id, $product_variation_id, $initial_quantity = 0)
    {   
        $quantity = $initial_quantity;

        $items = self::items();

        if (isset($items[self::generateKey($product_id, $product_variation_id)]))
            $quantity = $items[self::generateKey($product_id, $product_variation_id)]['quantity'];

        return $quantity;
    }

    public static function generateKey($product_id, $product_variation_id)
    {
        if (empty($product_variation_id))
            return $product_id;
        else
            return $product_id . '||' . $product_variation_id;
    }

    public static function parseKey($cart_key = '')
    {
        $cart_key_parts = explode('||', (string) $cart_key);

        return [
            $cart_key_parts[0] ?? 0,
            $cart_key_parts[1] ?? null
        ];
    }

    public static function clearDatabaseCart($user_id = null)
    {
        $user_id = $user_id ?? Auth::user()->id;

        // Remove cart items for the user from the database
        Cart::where('user_id', $user_id)->delete();

        Cache::forget('cart_total_' . $user_id);
    }

    public static function createOrder($data = [])
    {
        if ($data['final_price'] > 0) {
            $total_price = $data['final_price'];
        } else {
            $total_price = $data['total_price'];
        }

        // Create Order
        $order = new Order();
        $order->user_id = Auth::user()->id;
        $order->currency_id = $data['currency']->id;
        $order->status = 1;
        $order->total_price = $total_price;
        $order->extra_information = json_encode([
                'customer_contact_phone' => $data['phone'],
                'customer_contact_email' => $data['email'],
                'customer_additional_notes' => $data['order_notes'],
                'coupon_code' => $data['coupon_code'] ?? null,
                'coupon_discount_amount' => $data['coupon_discount_amount'] ?? null,
                'subtotal_amount' => $data['total_price'] ?? null,
            ]);
        $order->save();

        if ($data['coupon_discount_amount'] > 0) {
            $coupon = Coupon::where('code', $data['coupon_code'])->first();

            if(!empty($coupon)){
                $coupon->usage_limit = $coupon->usage_limit - 1;
                $coupon->save();
            }
        }

        // Save Order Address
        OrderAddress::create([
            'order_id' => $order->id,
            'shipping_address_id' => $data['shipping_address_id'],
            'billing_address_id' => $data['billing_address_id']
        ]);

        // Save Order Items
        $cart_items = self::items();
        foreach ($cart_items as $cart_key => $item) {

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product_id'],
                'product_variation_id' => $item['product_variation_id'],
                'quantity' => $item['quantity'],
                'price' => $item['product_price'],
            ]);
        }

        // Save Payment
        Payment::create([
            'order_id' => $order->id,
            'payment_method_id' => $data['payment_method_id'],
            'amount' => $total_price,
            'status' => 'pending', // Change as per your payment status logic
        ]);

        // Clear the cart after successful order placement
        // self::clearDatabaseCart();

        return $order->id;
    }

    public static function isEmpty()
    {
        return count(self::items()) == 0;
    }
        
}