<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductVariation extends Model
{
    use HasFactory, SoftDeletes;

    public $fillable = [
        'name', 'price', 'stock'
    ];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    //Accessors
    public function priceWithCurrency($currency_code = '')
    {
        if (empty($currency_code))
            $currency_code = __userCurrencyCode();

        $exchange_rate = 1;

        if (__userCurrencyCode() != __appCurrency()->code) {
            $currency = Currency::where('code', $currency_code)->select('exchange_rate')->first();
    
            $exchange_rate = $currency->exchange_rate ?? 1;
        }

        return ($this->price * $exchange_rate);
    }

    public function discountedPriceWithCurrency($currency_code = '') 
    {
        // Set default currency code
        if (empty($currency_code)) {
            $currency_code = __userCurrencyCode();
        }

        // Get exchange rate
        $exchange_rate = 1;
        if ($currency_code != __appCurrency()->code) {
            $currency = Currency::where('code', $currency_code)->select('exchange_rate')->first();
            $exchange_rate = $currency->exchange_rate ?? 1;
        }

        // Calculate original price with exchange rate
        $original_price = $this->price * $exchange_rate;

        // Get product discount details
        $product = $this->product;

        if ($product && $product->discount_value && $product->discount_start_date && $product->discount_end_date) {
            $today = now();

            // Check if the discount is valid
            if ($today->between($product->discount_start_date, $product->discount_end_date)) {
                if ($product->discount_type === 'amount') {
                    // Flat amount discount
                    $discounted_price = $original_price - ($product->discount_value * $exchange_rate);
                } elseif ($product->discount_type === 'percentage') {
                    // Percentage discount
                    $discounted_price = $original_price - ($original_price * ($product->discount_value / 100));
                } else {
                    $discounted_price = $original_price;
                }

                // Ensure discounted price is never negative and format to 2 decimals
                return number_format(max($discounted_price, 0), 2, '.', '');
            }
        }

        // Return original price if no discount applies
        return number_format($original_price, 2, '.', '');
    }
}
