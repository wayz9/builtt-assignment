<?php

namespace App\DTOs;

use App\Models\Product;

final class CartItem
{
    public function __construct(
        public readonly Product $product,
        public readonly int $quantity,
    ) {
    }

    /**
     * Get the total value of the cart item.
     */
    public function totalValue(): int
    {
        return $this->product->price * $this->quantity;
    }
}
