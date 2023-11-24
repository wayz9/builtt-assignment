<?php

use App\Livewire\CartCounter;
use App\Livewire\Product\Index;
use App\Livewire\Product\Item;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

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

describe('from products page', function() {
    beforeEach(function() {
        $this->user = User::factory()->create();
        $this->product = Product::factory()->withStock(20)->create();
    });

    test('user can add item to cart', function() {
        Livewire::actingAs($this->user)
            ->test(Item::class, ['product' => $this->product])
            ->call('addToCart', 2)
            ->assertHasNoErrors()
            ->assertDispatched('cart:updated');

        $this->user->cart->refresh();
        expect($this->user->cart->products->count())->toBe(1);
        expect($this->user->cart->products->value('pivot.quantity'))->toBe(2);
    });

    test('user cannot add more than available stock', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 10]);

        Livewire::actingAs($this->user)
            ->test(Item::class, ['product' => $this->product])
            ->call('addToCart', 15)
            ->assertHasErrors('quantity')
            ->assertNotDispatched('cart:updated');

        $this->user->cart->refresh();
        expect($this->user->cart->products->value('pivot.quantity'))->toBe(10);
    });

    test('user cannot add 0 items to cart', function() {
        Livewire::actingAs($this->user)
            ->test(Item::class, ['product' => $this->product])
            ->call('addToCart', 0)
            ->assertHasErrors('quantity')
            ->assertNotDispatched('cart:updated');

        $this->user->cart->refresh();
        expect($this->user->cart->products->count())->toBe(0);
    });

    test('cannot add out of stock item to cart', function() {
        $this->product->update(['stock' => 0]);

        Livewire::actingAs($this->user)
            ->test(Item::class, ['product' => $this->product])
            ->call('addToCart', 1)
            ->assertHasErrors('quantity')
            ->assertNotDispatched('cart:updated');

        $this->user->cart->refresh();
        expect($this->user->cart->products->count())->toBe(0);
    });
});