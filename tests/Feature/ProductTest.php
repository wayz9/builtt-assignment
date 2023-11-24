<?php

use App\Livewire\CartCounter;
use App\Livewire\Product\Index;
use App\Models\Product;
use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\get;

it('has product page', function () {
    get(route('products.index'))
        ->assertOk()
        ->assertSeeLivewire(Index::class);
});

it('loads product page with products', function() {
    $products = Product::factory()->create();

    get(route('products.index'))
        ->assertSee($products->name)
        ->assertSee(Product::count() . ' proizvoda');
});

test('logged in user can see cart button', function() {
    actingAs(User::factory()->create());

    get(route('products.index'))
        ->assertSeeLivewire(CartCounter::class);
});