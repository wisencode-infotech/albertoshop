<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'user_id',
        'status',
        'total_price'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($order) {
            $prefix = __setting('order_number_prefix') ?? 'ORD-';

            do {
                $latestOrder = self::latest('id')->first();
                $nextId = $latestOrder ? $latestOrder->id + 1 : 1;
                $orderNumber = $prefix . $nextId;

                if (self::where('order_number', $orderNumber)->exists()) {
                    $orderNumber .= '-' . Str::random(4);
                }

                $order->order_number = $orderNumber;

            } while (self::where('order_number', $order->order_number)->exists());
        });
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'order_items')
                    ->withPivot('quantity', 'price', 'product_variation_id')
                    ->withTimestamps();
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(OrderAddress::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Accessors
    public function getCustomerContactEmailAttribute()
    {
        $order_extra_information = json_decode($this->extra_information, true);

        if (!empty($order_extra_information) && !empty($order_extra_information['customer_contact_email']))
            return $order_extra_information['customer_contact_email'];
        else    
            return $this->customer->email;
    }

    public function getCustomerContactNumberAttribute()
    {
        $order_extra_information = json_decode($this->extra_information, true);

        if (!empty($order_extra_information) && !empty($order_extra_information['customer_contact_phone']))
            return $order_extra_information['customer_contact_phone'];
        else    
            return $this->customer->email;
    }

    public function getSubtotalAmountAttribute()
    {
        $order_extra_information = json_decode($this->extra_information, true);

        if (!empty($order_extra_information) && !empty($order_extra_information['subtotal_amount']))
            return $order_extra_information['subtotal_amount'];
        else    
            return $this->total_price;
    }

    public function getDiscountAmountAttribute()
    {
        $order_extra_information = json_decode($this->extra_information, true);

        if (!empty($order_extra_information) && !empty($order_extra_information['coupon_discount_amount']))
            return $order_extra_information['coupon_discount_amount'];
        else    
            return 0;
    }
}
