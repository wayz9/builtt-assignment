<?php

namespace App\Livewire;

use App\Contracts\CartContract;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCounter extends Component
{
    #[On('cart:updated')]
    public function render(): View
    {
        /** @var CartContract $cart */
        $cart = resolve(CartContract::class);

        return view('livewire.cart-counter', [
            'totalItems' => $cart->count(),
        ]);
    }
}
