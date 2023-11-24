<?php

use App\Livewire\Cart\Index;
use App\Models\Product;
use App\Models\User;
use Livewire\Livewire;

use function Pest\Laravel\actingAs;

it('has cart page', function () {
    actingAs(User::factory()->create()) 
        ->get('/cart')
        ->assertOk()
        ->assertSeeLivewire(Index::class);
});

describe('cart functionality - ', function() {
    beforeEach(function() {
        $this->product = Product::factory()->create([
            'stock' => 50,
        ]);
        $this->user = User::factory()->create();
    });

    test('cart products are visible', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 2]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->assertSet('cart', auth()->user()->cart->load('products'))
            ->assertSee($this->product->name)
            ->assertSee(number_format($this->product->price * 2 / 100, 2, ',', '.'));
    });

    test('can remove item from cart', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 2]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->assertSee($this->product->name)   
            ->call('removeFromCart', $this->product)
            ->assertDontSee($this->product->name)
            ->assertHasNoErrors();

        expect($this->user->cart->refresh()->itemsCount())->toBe(0);
    });

    test('can add an item to cart', function() {
        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('addToCart', $this->product, 2)
            ->assertHasNoErrors()
            ->assertDispatched('cart:updated');

        expect($this->user->cart->refresh()->itemsCount())->toBe(2);
    });

    test('can update quantity on cart item', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 2]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('updateCartItem', $this->product, 4)
            ->assertHasNoErrors()
            ->assertDispatched('cart:updated');

        expect($this->user->cart->refresh()->itemsCount())->toBe(4);
    });

    test('adding same item to cart updates quantity', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 2]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('addToCart', $this->product, 2)
            ->assertHasNoErrors()
            ->assertDispatched('cart:updated');

        expect($this->user->cart->refresh()->itemsCount())->toBe(4);
    });

    test('updating cart item quantity to 0 removes it from cart', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 2]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('updateCartItem', $this->product, 0)
            ->assertHasNoErrors();

        expect($this->user->cart->refresh()->itemsCount())->toBe(0);
    }); 

    test('doesnt allow adding more items than available in stock', function() {
        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('addToCart', $this->product, 51)
            ->assertHasErrors('quantity', "Product {$this->product->name} has only {$this->product->stock} items in stock.")
            ->assertNotDispatched('cart:updated');

        expect($this->user->cart->refresh()->itemsCount())->toBe(0);
    });

    test('cannot add item that is out of stock', function() {
        $this->product->update(['stock' => 0]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('addToCart', $this->product, 1)
            ->assertHasErrors('quantity', "Product {$this->product->name} is out of stock.")
            ->assertNotDispatched('cart:updated');

        expect($this->user->cart->refresh()->itemsCount())->toBe(0);
    });

    test('guest user cannot add item to cart', function() {
        Livewire::test(Index::class)
            ->call('addToCart', $this->product, 2)
            ->assertHasErrors('user', 'You must be logged in to add items to cart.')
            ->assertNotDispatched('cart:updated');
    });

    test('cannot add 0 items to cart', function() {
        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('addToCart', $this->product, 0)
            ->assertHasErrors('quantity', 'Quantity must be at least 1.')
            ->assertNotDispatched('cart:updated');

        expect($this->user->cart->refresh()->itemsCount())->toBe(0);
    });

    test('cannot add more than max stock', function() {
        $this->user->cart->products()->attach($this->product, ['quantity' => 40]);

        Livewire::actingAs($this->user)
            ->test(Index::class)
            ->call('addToCart', $this->product, 40)
            ->assertHasErrors('quantity', "Product {$this->product->name} has only {$this->product->stock} items in stock.")
            ->assertNotDispatched('cart:updated');

        expect($this->user->cart->refresh()->itemsCount())->toBe(40);
    });
});
