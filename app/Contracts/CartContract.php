<?php

namespace App\Contracts;

use App\DTOs\CartItem;
use App\Models\Product;
use Illuminate\Support\Collection;

interface CartContract
{
    /**
     * Add a product to the cart.
     */
    public function add(Product $product, int $quantity = 1): void;

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product): void;

    /**
     * Get cart items count.
     */
    public function total(): int;

    /**
     * Get cart items count.
     */
    public function count(): int;

    /**
     * Retrieve the cart items.
     * 
     * @return Collection<CartItem>
     */
    public function items(): Collection;
}
