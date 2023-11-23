<?php

namespace App\Livewire\Product;

use App\Concerns\WorksWithCart;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Cache;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    use WorksWithCart;

    public Collection $products;
    public Cart $cart;

    public function mount(): void
    {
        $this->products = Cache::remember('products', 60 * 60, fn () => Product::all());
        $this->cart = auth()->check() 
            ? auth()->user()->cart->load('products') 
            : new Cart();
    }

    #[Layout('components.layouts.app')]
    public function render(): View
    {
        return view('livewire.product.index');
    }
}
