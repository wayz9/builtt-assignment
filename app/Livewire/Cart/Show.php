<?php

namespace App\Livewire\Cart;

use App\Contracts\CartContract;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class Show extends Component
{
    #[On('cart:updated')]
    public function render(): View
    {
        /** @var CartContract $cart */
        $cart = resolve(CartContract::class);

        return view('livewire.cart.index', [
            'total' => number_format($cart->total() / 100, 2, ',', '.'),
            'items' => $cart->items(),
            'count' => $cart->count(),
        ]);
    }
}
