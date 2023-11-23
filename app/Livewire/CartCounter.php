<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;

class CartCounter extends Component
{   
    #[On('cart:updated')]
    public function render()
    {
        return view('livewire.cart-counter', [
            'totalItems' => auth()->user()->cart->itemsCount(),
        ]);
    }
}
