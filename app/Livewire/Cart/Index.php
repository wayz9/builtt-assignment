<?php

namespace App\Livewire\Cart;

use App\Concerns\WorksWithCart;
use App\Models\Cart;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Index extends Component
{
    use WorksWithCart;

    public Cart $cart;

    public function mount(): void
    {
        $this->cart = auth()->check()
            ? auth()->user()->cart->load('products')
            : new Cart();
    }

    #[On('cart:updated')]
    public function render(): View
    {
        return view('livewire.cart.index', [
            'cartTotal' => number_format($this->cart->total() / 100, 2, ',', '.'),
            'cartItems' => $this->cart->products,
        ]);
    }
}
