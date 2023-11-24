<?php

namespace App\Livewire;

use Illuminate\Contracts\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class CartCounter extends Component
{   
    #[On('cart:updated')]
    public function render(): View
    {
        return view('livewire.cart-counter', [
            'totalItems' => auth()->user()->cart->itemsCount(),
        ]);
    }
}
