<?php

use App\Contracts\CartContract;
use App\DTOs\CartItem;
use App\Models\Product;
use App\Models\User;
use App\Services\Cart\DatabaseCart;
use App\Services\Cart\SessionCart;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

beforeEach(function() {
    $this->user = User::factory()->create();
    $this->product = Product::factory()->withStock(20)->create();
    $this->product2 = Product::factory()->withStock(20)->create();
    Auth::login($this->user);
});

test('container can resolve correct driver', function() {
    $cart = resolve(CartContract::class);
    expect($cart)->toBeInstanceOf(DatabaseCart::class);

    Auth::logout();
    $cart = resolve(CartContract::class);
    expect($cart)->toBeInstanceOf(SessionCart::class);
});

test('can retrieve items from cart', function() {
    $this->user->cart->products()->attach($this->product, ['quantity' => 10]);

    $cart = resolve(CartContract::class);
    $items = $cart->items();

    expect($items)
        ->toBeInstanceOf(Collection::class)
        ->count()->toBe(1)
        ->first()->toBeInstanceOf(CartItem::class)
        ->and($items->first()->quantity)->toBe(10)
        ->and($items->first()->product->is($this->product))->toBeTrue();
});

test('can add item to cart', function() {
    /** @var CartContract $cart */
    $cart = resolve(CartContract::class);
    $cart->add($this->product, 2);

    $this->user->cart->refresh();
    expect($this->user->cart->products->count())->toBe(1);
    expect($this->user->cart->products->value('pivot.quantity'))->toBe(2);
});

test('can remove item from cart', function() {
    $this->user->cart->products()->attach($this->product, ['quantity' => 10]);

    /** @var CartContract $cart */
    $cart = resolve(CartContract::class);
    $cart->remove($this->product);

    $this->user->cart->refresh();
    expect($this->user->cart->products->count())->toBe(0);
});

test('adding same item to cart increases quantity', function() {
    $this->user->cart->products()->attach($this->product, ['quantity' => 10]);

    /** @var CartContract $cart */
    $cart = resolve(CartContract::class);
    $cart->add($this->product, 2);

    $this->user->cart->refresh();
    expect($this->user->cart->products->count())->toBe(1);
    expect($this->user->cart->products->value('pivot.quantity'))->toBe(12);
});

test('cannot add 0 items to cart', function() {
    /** @var CartContract $cart */
    $cart = resolve(CartContract::class);
    $cart->add($this->product, 0);
})->throws(ValidationException::class, 'Quantity must be at least 1');

test('cannot add item to cart that is out of stock', function() {
    $this->product->update(['stock' => 0]);

    /** @var CartContract $cart */
    $cart = resolve(CartContract::class);
    $cart->add($this->product, 1);
})->throws(ValidationException::class);

test('cannot add more items to cart than available stock', function() {
    /** @var CartContract $cart */
    $cart = resolve(CartContract::class);
    $cart->add($this->product, 21);
})->throws(ValidationException::class);

test('can remove only a certain quantity of item in cart', function() {
    $this->user->cart->products()->attach($this->product, ['quantity' => 10]);

    /** @var CartContract $cart */
    $cart = resolve(CartContract::class);
    $cart->remove($this->product, 5);

    $this->user->cart->refresh();
    expect($this->user->cart->products->value('pivot.quantity'))->toBe(5);
});
