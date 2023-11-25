<?php

use App\Livewire\Cart\Item;
use App\Livewire\Cart\Show;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('has cart page', function () {
    actingAs(User::factory()->create()) 
        ->get('/cart')
        ->assertOk()
        ->assertSeeLivewire(Show::class);
});

describe('cart functionality', function() {
    beforeEach(function() {
        $this->product = Product::factory()->withStock(50)->create();
        $this->user = User::factory()->create();
    });

    test('cart item renders product correctly', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 2]);
    
        Livewire::actingAs($this->user)
            ->test(Item::class, ['product' => $this->product, 'quantity' => 2])
            ->assertSee($this->product->name);
    });

    test('cart products are visible', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 2]);

        Livewire::actingAs($this->user)
            ->test(Show::class)
            ->assertSee($this->product->name)
            ->assertSee(number_format($this->product->price * 2 / 100, 2, ',', '.'));
    });

    test('can remove item from cart', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 2]);

        Livewire::actingAs($this->user)
            ->test(Item::class, ['product' => $this->product, 'quantity' => 2])
            ->call('remove')
            ->assertDispatched('cart:updated');

        expect($this->user->cart->refresh()->products->count())->toBe(0);
    });

    test('can increment cart item quantity', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 2]);

        Livewire::actingAs($this->user)
            ->test(Item::class, ['product' => $this->product, 'quantity' => 2])
            ->call('increment')
            ->assertHasNoErrors()
            ->assertSet('quantity', 3)
            ->assertDispatched('cart:updated');

        expect($this->user->cart->refresh()->products->value('pivot.quantity'))->toBe(3);
    });

    test('decrementing cart quantity to 0 removes the item', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 1]);

        Livewire::actingAs($this->user)
            ->test(Item::class, ['product' => $this->product, 'quantity' => 1])
            ->call('decrement')
            ->assertHasNoErrors();

        expect($this->user->cart->refresh()->products)->toBeEmpty();
    });

    test('can decrement cart item quantity', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 10]);

        Livewire::actingAs($this->user)
            ->test(Item::class, ['product' => $this->product, 'quantity' => 10])
            ->call('decrement')
            ->assertHasNoErrors()
            ->assertSet('quantity', 9)
            ->assertDispatched('cart:updated');

        expect($this->user->cart->refresh()->products->value('pivot.quantity'))->toBe(9);
    });

    test('cannot increment past stock max value', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 50]);

        Livewire::actingAs($this->user)
            ->test(Item::class, ['product' => $this->product, 'quantity' => 50])
            ->call('increment')
            ->assertHasErrors('quantity', "Product {$this->product->name} has only {$this->product->stock} items in stock.")
            ->assertNotDispatched('cart:updated');

        expect($this->user->cart->refresh()->products->value('pivot.quantity'))->toBe(50);
    });
});
