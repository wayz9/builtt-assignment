<?php

namespace App\Services\Cart;

use App\Contracts\CartContract;
use App\DTOs\CartItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

class DatabaseCart implements CartContract
{
    public function __construct(
        protected Cart $cart
    ) {
        $this->cart->loadMissing('products');
    }

    /**
     * @inheritDoc
     */
    public function items(): Collection
    {
        return $this->cart->refresh()->products->map(fn (Product $product) => 
            new CartItem($product, $product->pivot->quantity)
        );
    }

    /**
     * Add a product to the cart.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function add(Product $product, int $quantity = 1): void
    {
        $quantity += $this->items()
            ->firstWhere('product.id', $product->getKey())
            ?->quantity ?? 0;

        $this->canBeAddedToCart($product, $quantity);

        if ($this->productExistsInCart($product)) {
            $this->cart->products()->updateExistingPivot($product, [
                'quantity' => $quantity,
            ]);

            return;
        }

        $this->cart->products()->attach($product, ['quantity' => $quantity]);
    }

    /**
     * Remove a product from the cart.
     */
    public function remove(Product $product): void
    {
        $this->cart->products()->detach($product);
    }

    /**
     * Get cart items count.
     */
    public function count(): int
    {
        return $this->items()->count();
    }

    /**
     * Get cart total.
     */
    public function total(): int
    {
        return $this->items()
            ->sum(fn (CartItem $item) 
                => $item->totalValue()
            );
    }

    private function canBeAddedToCart(Product $product, int $quantity): void
    {
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

        if ($quantity > $product->stock) {
            throw ValidationException::withMessages([
                'quantity' => "Product {$product->name} has only {$product->stock} items in stock.",
            ]);
        }
    }

    /**
     * Check if product exists in cart.
     */
    public function productExistsInCart(Product $product): bool
    {
        return $this->items()
            ->pluck('product')
            ->contains(fn (Product $p) => $p->is($product));
    }
}
