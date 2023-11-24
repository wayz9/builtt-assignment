<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('cart_product', function (Blueprint $table) {
            $table->foreignUuid('cart_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignUuid('product_id')
                ->constrained()
                ->cascadeOnDelete();
            $table->integer('quantity')
                ->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cart_product');
    }
};
