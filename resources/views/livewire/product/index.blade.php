<div>
    <h1 class="font-bold mt-12">
        Svi Proizvodi&nbsp;
        <span class="text-sm font-normal text-stone-500">{{ App\Models\Product::count() }} proizvoda</span>
    </h1>

    <div class="mt-7 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-x-6 gap-y-12 pb-16">
        @foreach ($products as $product)
            <livewire:product.item :$product :key="$product->id" />
        @endforeach
    </div>
</div>
