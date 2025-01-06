<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'stock',
        'category_id',
        'public_visibility',
        'status',
    ];

    // Relationships
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class)->withTrashed();
    }

    public function orders(): BelongsToMany
    {
        return $this->belongsToMany(Order::class, 'order_items')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(ProductReview::class);
    }

    public function cartItems(): HasMany
    {
        return $this->hasMany(Cart::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)->orderBy('is_primary', 'DESC');
    }

    public function displayImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)->where('is_primary', '1');
    }

    public function variations(): HasMany
    {
        return $this->hasMany(ProductVariation::class);
    }

    // Accessors
    public function getDisplayImageURLAttribute()
    {
        $display_image = $this->displayImage;
        
        return (!empty($display_image)) ? $display_image->image_url : ProductImage::$placeholder_url;
    }

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
        if (empty($currency_code)) {
            $currency_code = __userCurrencyCode();
        }

        $exchange_rate = 1;
        if ($currency_code != __appCurrency()->code) {
            $currency = Currency::where('code', $currency_code)->select('exchange_rate')->first();
            $exchange_rate = $currency->exchange_rate ?? 1;
        }

        $original_price = $this->price * $exchange_rate;

        if ($this->discount_value && $this->discount_start_date && $this->discount_end_date) {
            
            $today = now();

            if ($today->between($this->discount_start_date, $this->discount_end_date)) {
                if ($this->discount_type === 'amount') {
                    $discounted_price = $original_price - ($this->discount_value * $exchange_rate);
                } elseif ($this->discount_type === 'percentage') {
                    $discounted_price = $original_price - ($original_price * ($this->discount_value / 100));
                } else {
                    $discounted_price = $original_price;
                }

                $discounted_price = max($discounted_price, 0);
                return number_format($discounted_price, 2, '.', '');
            }
        }

        return number_format($original_price, 2, '.', '');
    }


    public function getTotalReviewsAttribute($rating = null)
    {
        $reviews = $this->reviews();

        if (!is_null($rating))
            $reviews = $reviews->where('rating', $rating);

        return $reviews->select('id')->count();
    }

    public function getAverageRatingAttribute()
    {
        return number_format($this->reviews()->avg('rating') ?? 0, 1);
    }

    public function getTotalVariationsAttribute()
    {
        return ProductVariation::select('id')->where('product_id', $this->id)->count();
    }

    public function getVariationNamesAttribute()
    {
        return ProductVariation::select('name')->where('product_id', $this->id)->pluck('name');
    }

    // Helper functions
    public function makePrimaryImage() 
    {
        $product_image = $this->images()->where('is_primary', '1')->first();

        if ( empty($product_image) && $this->images->count() > 0) {
            $first_image = $this->images()->first();
            $first_image->is_primary = '1';
            $first_image->save();
        }
    }

    // Scopes
    public function scopeAuthenticated(Builder $query): Builder
    {
        if (!__isAdmin())
            return $query->whereIn('public_visibility', [1, 0]);

        return $query;
    }

}
