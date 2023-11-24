<?php

namespace App\Livewire\Product;

use App\Contracts\CartContract;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Item extends Component
{
    public Product $product;

    /**
     * Add the product to the cart.
     */
    public function addToCart($quantity): void
    {
        validator(['quantity' => $quantity], [
            'quantity' => ['required', 'integer', 'min:1'],
        ])->validate();

        /** @var CartContract $cart */
        $cart = resolve(CartContract::class);

        $cart->add($this->product, $quantity);
        $this->dispatch('cart:updated');
    }

    public function render(): View
    {
        return view('livewire.product.item');
    }
}
