<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\SiteBanner;
use App\Models\User;
use App\Models\ProductUnit;
use App\Models\Currency;
use App\Models\ProductReview;
use App\Models\Notification;
use App\Models\UserRole;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class FakeAppSeeder extends Seeder
{
    /**
     * Seed the application's database for fake entries. specially for test setup.
     */
    public function run(): void
    {
        // User roles seeder

        UserRole::insert([
            [
                'id' => 1,
                'role' => 'admin',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 2,
                'role' => 'buyer',
                'created_at' => date('Y-m-d H:i:s')
            ],
            [
                'id' => 3,
                'role' => 'franchise',
                'created_at' => date('Y-m-d H:i:s')
            ]
        ]);

        // User seeder

        User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('cbd2024!#'),
            'user_role_id' => 1
        ]);

        User::factory(10)->create();

        // Categories seeder

        $categories = ['Cannabis Bulk Flowers', 'Cannabis Bulk Hash', 'Cannabis Bulk Isolate', 'Cannabis Bulk Distilate', 'Cannabis Bulk Terpenes', 'Cannabis Bulk Extracts'];

        foreach ($categories as $category) {
            Category::create([
                'name' => $category,
                'slug' => Str::slug($category),
                'description' => $category . ' description',
            ]);
        }

        // Products seeder

        $categories = Category::all();
        $product_unit_ids = ProductUnit::pluck('id')->toArray();

        foreach ($categories as $category) {
            Product::factory(10)->create([
                'category_id' => $category->id,
                'unit_id' => $product_unit_ids[array_rand($product_unit_ids)]
            ]);
        }

        // Order seeder

        $users = User::all();
        $products = Product::all();
        $currency_ids = Currency::pluck('id')->toArray();

        foreach ($users as $user) {
            $order = Order::create([
                'user_id' => $user->id,
                'currency_id' => $currency_ids[array_rand($currency_ids)],
                'status' => array_rand(config('general.order_statuses')),
                'total_price' => 0,
            ]);

            $totalPrice = 0;

            foreach ($products->random(3) as $product) {
                $quantity = rand(1, 5);
                $price = $product->price * $quantity;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $price,
                ]);

                $totalPrice += $price;
            }

            $order->update(['total_price' => $totalPrice]);
        }

        // Payment methods seeder

        $payment_methods = [
            [
                'name' => 'CoinPayments',
                'description' => 'Secure & Trusted Crypto Payment Gateway',
                'logo_url' => 'https://www.coinpayments.net/2024.03/img/cps-since.svg',
                'is_default' => true
            ],
            [
                'name' => 'Cash on Delivery',
                'description' => 'Pay on Delivery',
                'logo_url' => 'https://img.freepik.com/premium-vector/cash-delivery_569841-175.jpg?w=826',
                'is_default' => false
            ]
        ];

        foreach ($payment_methods as $payment_method) {
            PaymentMethod::create($payment_method);
        }

        // Payment seeder

        $orders = Order::all();
        $payment_method_ids = PaymentMethod::pluck('id')->toArray();

        foreach ($orders as $order) {
            Payment::create([
                'order_id' => $order->id,
                'payment_method_id' => $payment_method_ids[array_rand($payment_method_ids)],
                'amount' => $order->total_price,
                'status' => 'completed',
            ]);
        }

        // Products review seeder

        $product_ids = Product::pluck('id')->toArray();

        $user_ids = User::pluck('id')->toArray();

        $product_review_counter = 0;

        while ($product_review_counter <= 200) {
            ProductReview::create([
                'user_id' => $user_ids[array_rand($user_ids)],
                'product_id' => $product_ids[array_rand($product_ids)],
                'rating' => rand(1, 5),
                'review' => fake()->paragraph()
            ]);

            $product_review_counter++;
        }

        // Notification seeder

        $user_ids = User::pluck('id')->toArray();

        $notification_types = ['order'];

        $global_status = [true, false];

        $notification_counter = 0;

        while ($notification_counter <= 200) {
            Notification::create([
                'title'     => fake()->sentence(),
                'message'   => fake()->paragraph(),
                'user_id'   => $user_ids[array_rand($user_ids)],
                'is_global' => $global_status[array_rand($global_status)],
                'type'      => $notification_types[array_rand($notification_types)],
                'url'       => fake()->url(),
                'meta_data' => json_encode(['key' => fake()->word()]),
                'is_read'   => rand(0, 1) == 1,
            ]);

            $notification_counter++;
        }


        // Site banner seeder

        $site_banners = ['Cash on Delivery', 'Gift Voucher', 'Free Delivery', 'Coupon Saving'];

        foreach ($site_banners as $site_banner) {
            SiteBanner::create([
                'title' => $site_banner,
                'description' => fake()->paragraph()
            ]);
        }
    }
}
