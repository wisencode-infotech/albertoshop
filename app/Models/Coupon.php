<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'discount_value',
        'discount_type',
        'valid_from',
        'valid_until',
        'usage_limit',
    ];

     /**
     * Get the coupon code from the extra_information field.
     *
     * @return string|null
     */
    public function getCouponCodeAttribute()
    {
        // Decode the JSON in extra_information and return the coupon_code if it exists
        $extraInfo = json_decode($this->extra_information, true);
        
        // Return the coupon_code if it exists, or null if not
        return $extraInfo['coupan_code'] ?? null;
    }

    /**
     * Check if the coupon is valid based on dates and usage limit.
     */
    public function isValid()
    {
        $now = now();

        // Check date validity
        if ($now->lt($this->valid_from) || $now->gt($this->valid_until)) {
            return false;
        }

        // Check usage limit
        $usedCount = Order::whereJsonContains('extra_information->coupan_code', $this->code)->count();
        if ($usedCount >= $this->usage_limit) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount based on the given total price.
     */
    public function calculateDiscount($totalPrice)
    {
        if ($this->discount_type === 'flat') {
            return $this->discount_value;
        } elseif ($this->discount_type === 'percentage') {
            return ($totalPrice * $this->discount_value) / 100;
        }

        return 0;
    }
}
