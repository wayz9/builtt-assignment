<?php

namespace App\Concerns;

use App\Models\Product;
use Illuminate\Validation\ValidationException;

trait WorksWithCart
{
    public function addToCart(Product $product, int $quantity = 1): void
    {
        $this->canBeAddedToCart($product, $quantity);

        if ($this->cart->productExistsInCart($product)) {
            $newQuantity = $this->cart->products->firstWhere('id', $product->id)->pivot->quantity + $quantity;
            $this->updateCartItem($product, $newQuantity);
        } else {
            $this->products()->attach($product, ['quantity' => $quantity]);
        }

        $this->dispatch('cart:updated');
    }

    public function updateCartItem(Product $product, int $quantity): void
    {
        if ($quantity === 0) {
            $this->removeFromCart($product);

            return;
        }

        $this->canBeAddedToCart($product, $quantity);

        $this->cart->products()->updateExistingPivot($product, [
            'quantity' => $quantity,
        ]);

        $this->dispatch('cart:updated');
    }

    public function removeFromCart(Product $product): void
    {
        $this->cart->products()->detach($product);
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    private function canBeAddedToCart(Product $product, int $quantity): void
    {
        if (auth()->guest()) {
            throw ValidationException::withMessages([
                'guest' => 'You must be logged in to add products to the cart.',
            ]);
        }

        if ($quantity < 1) {
            throw ValidationException::withMessages([
                'quantity' => 'Quantity must be at least 1.',
            ]);
        }

        if ($product->isOutOfStock()) {
            throw ValidationException::withMessages([
                'quantity' => "Product {$product->name} is out of stock.",
            ]);
        }

        if ($this->cart->productExistsInCart($product)) {
            $newQuantity = $this->cart->products->firstWhere('id', $product->id)->pivot->quantity + $quantity;
            
            if ($newQuantity > $product->stock) {
                throw ValidationException::withMessages([
                    'quantity' => "Product {$product->name} has only {$product->stock} items in stock.",
                ]);
            }
        }
    }
}
