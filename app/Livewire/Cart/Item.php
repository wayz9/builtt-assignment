<?php

namespace App\Livewire\Cart;

use App\Contracts\CartContract;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Item extends Component
{
    public Product $product;
    public int $quantity;

    public function remove(): void
    {
        /** @var CartContract $cart */
        $cart = resolve(CartContract::class);

        $cart->remove($this->product);
        $this->dispatch('cart:updated');
    }

    public function increment(): void
    {
        /** @var CartContract $cart */
        $cart = resolve(CartContract::class);
        $cart->add($this->product, 1);

        $this->quantity++;
        $this->dispatch('cart:updated');
    }

    public function decrement(): void
    {
        /** @var CartContract $cart */
        $cart = resolve(CartContract::class);

        $cart->remove($this->product, decrease: 1);
        $this->quantity--;
        $this->dispatch('cart:updated');
    }

    public function render(): View
    {
        return view('livewire.cart.item');
    }
}
