<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StockReminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'email', 'product_id', 'product_variation_id'
    ];
}
