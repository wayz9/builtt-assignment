<?php

namespace App\Providers;

use App\Contracts\CartContract;
use App\Services\Cart\SessionCart;
use App\Services\Cart\DatabaseCart;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(CartContract::class, function() {
            return auth()->check()
                ? new DatabaseCart(auth()->user()->cart->load('products'))
                : new SessionCart();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::unguard();
        Model::shouldBeStrict();
    }
}
