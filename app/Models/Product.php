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
        return $this->belongsTo(Category::class);
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

    public function getDiscountedPriceAttribute($currency_code = '') 
    {
        return $this->priceWithCurrency($currency_code);
    }

    public function getTotalReviewsAttribute()
    {
        return $this->reviews()->select('id')->count();
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()->avg('rating') ?? 0;
    }

    public function getTotalVariationsAttribute()
    {
        return ProductVariation::select('id')->where('product_id', $this->id)->count();
    }

    public function getVariationNamesAttribute()
    {
        return ProductVariation::select('name')->where('product_id', $this->id)->pluck('name');
    }

    // scope
    protected static function booted()
    {
        static::addGlobalScope('public_visibility', function (Builder $builder) {
            $builder->where('public_visibility', '1');
        });
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

}
