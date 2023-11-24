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
    #[Layout('components.layouts.app')]
    public function render(): View
    {
        $products = Cache::remember(
            key: 'products', 
            ttl: 60 * 60, 
            callback: fn () => Product::all()
        );

        return view('livewire.product.index', [
            'products' => $products,
        ]);
    }
}
