<?php

use App\Models\Product;
use App\Models\Translation;
use App\Models\Cart;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

if (!function_exists('__trans')) 
{
    function __trans($key, $locale = null, $group = null)
    {
        $locale = $locale ?? app()->getLocale(); // Get the current locale if not passed
        $cacheKey = "translation.{$locale}.{$group}.{$key}";

        // Try to retrieve the translation from cache
        return Cache::rememberForever($cacheKey, function () use ($key, $locale, $group) {
            $query = Translation::where('locale', $locale)->where('key', $key);

            if ($group) {
                $query->where('group', $group);
            }

            $translation = $query->first();

            // If translation exists, return the value
            if ($translation) {
                return $translation->value;
            }

            // If not found, insert it with the key as the value
            Translation::create([
                'locale' => $locale,
                'group'  => $group,
                'key'    => $key,
                'value'  => $key,  // Default to key as value
            ]);

            // Return the key as a fallback for now
            return $key;
        });
    }
}

if (!function_exists('updateCart')) 
{
    function updateCart($productId, $quantity)
    {
        if (auth()->check()) {

            if ($quantity > 0) {
                Cart::updateOrCreate(
                    [
                        'user_id' => auth()->user()->id,
                        'product_id' => $productId,
                    ],
                    ['quantity' => $quantity]
                );
            } else {
                Cart::where('user_id', auth()->user()->id)
                    ->where('product_id', $productId)
                    ->delete();
            }
        } else {
            
            $cart = shoppingCart();

            if ($quantity > 0) {
                $cart[$productId] = [
                    'quantity' => $quantity,
                ];
            } else {
                unset($cart[$productId]);
            }

            Session::put('cart', $cart);
        }
    }
}



if (!function_exists('shoppingCart')) 
{
    function shoppingCart($options = [])
    {

        $cart_items = [];

        if (auth()->check()) {

            $db_cart_items  = Cart::where('user_id', auth()->user()->id)->get();

            $cart_items = [];

            foreach ($db_cart_items as $db_item) {
                $cart_items[$db_item->product_id] = [
                    'quantity' => $db_item->quantity,
                    'product_price' => $db_item->product->price ?? 0,
                    'product' => $db_item->product,
                ];
            }

            return $cart_items;

        } else {

            $cart_items = Session::get('cart', []);

            foreach ($cart_items as $product_id => &$item) {
                $product = Product::find($product_id);

                if ($product) {
                    $item['product'] = $product;
                    $item['product_price'] = ($product->price ?? 0);
                }
            }

            return $cart_items;
        }
    }
}

if (!function_exists('shoppingCartTotal')) 
{
    function shoppingCartTotal()
    {
        $cart_items = shoppingCart();

        $total = 0;

        foreach ($cart_items as $item) {
            $total += ($item['quantity'] ?? 0) * ($item['product_price'] ?? 0);
        }

        return $total;
    }
}
