<?php

namespace App\Models;

use App\Enum\SizeUnit;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $appends = [
        'product_image_url',
        'formatted_price',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'size_unit' => SizeUnit::class,
    ];

    /**
     * Update product image.
     */
    public function updateImage(UploadedFile $photo): void
    {
        tap($this->image_path, function($previous) use ($photo) {
            $this->forceFill([
                'image_path' => $photo->storePublicly('products')
            ])->save();

            if ($previous) {
                Storage::delete($previous);
            }
        });
    }
  
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

    /**
     * Get formatted price.
     */
    public function formattedPrice(): Attribute
    {
        return Attribute::get(fn () 
            => number_format($this->price / 100, 2, ',', '.')
        );
    }

    /**
     * Check if product is out of stock.
     */
    public function isOutOfStock(): bool
    {
        return $this->stock === 0;
    }
}
