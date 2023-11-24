<?php

namespace App\Services\Cart;

use App\Contracts\CartContract;
use App\DTOs\CartItem;
use App\Models\Product;
use Illuminate\Support\Collection;

class SessionCart implements CartContract
{
    public function add(Product $product, int $quantity = 1): void
    {
        $items = session()->get('cart', []);

        if ($this->productExistsInCart($product)) {
            $items[$product->id] += $quantity;
            session()->put('cart', $items);
            return;
        }

        $items = session()->get('cart', []);
        $items[$product->id] = $quantity;

        session()->put('cart', $items);
    }

    public function remove(Product $product): void
    {
        $items = session()->get('cart', []);

        unset($items[$product->id]);
        session()->put('cart', $items);
    }

    public function total(): int
    {
        return $this->items()->sum(fn (CartItem $item) => $item->totalValue());
    }

    public function count(): int
    {   
        return count(session()->get('cart', [])); 
    }

    public function items(): Collection
    {
        $items = session()->get('cart', []);
        
        return Product::find(array_keys($items))
            ->map(fn (Product $product) => new CartItem(
                product: $product,
                quantity: $items[$product->id]
            ));
    }

    private function productExistsInCart(Product $product): bool
    {
        $items = session()->get('cart', []);

        return isset($items[$product->id]);
    }
}
