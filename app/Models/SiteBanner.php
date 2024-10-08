<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class SiteBanner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'image_path'
    ];

    // Define a placeholder URL
    public static $placeholder_url = 'https://placehold.co/445x205';

    // Accessors
    public function getImageUrlAttribute()
    {
        // Check if image_path is set and the file exists
        if ($this->image_path && Storage::disk('public')->exists($this->image_path)) {
            return Storage::disk('public')->url($this->image_path); // Return the URL of the stored image
        }

        // If image_path is not set or file does not exist, return the placeholder URL
        return self::$placeholder_url; // Ensure to use self:: for static property access
    }
}
