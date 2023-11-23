<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cart extends Model
{
    use HasFactory, HasUuids;

    /**
     * Get cart products.
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class)
            ->withPivot('quantity');
    }

    /**
     * Get cart user.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get cart items count.
     */
    public function itemsCount(): int
    {
        return $this->products->sum('pivot.quantity');
    }

    /**
     * Get cart total.
     */
    public function total(): int
    {
        return $this->products->sum(fn (Product $product) 
            => $product->price * $product->pivot->quantity
        );
    }

    /**
     * Check if product exists in cart.
     */
    public function productExistsInCart(Product $product): bool
    {
        return $this->products->contains($product);
    }
}
