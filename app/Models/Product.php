<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
  
    /**
     * Get product image url.
     */
    public function productImageUrl(): Attribute
    {
        return Attribute::get(fn () => $this->image_path
            ? Storage::url($this->image_path)
            : asset('images/default.png')
        );
    }
}
