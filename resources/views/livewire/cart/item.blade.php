<div class="py-5 flex">
    <div class="flex gap-x-6 md:gap-x-9 flex-1">
        <div class="shrink-0 bg-stone-100 rounded flex items-center justify-center aspect-square w-36">
            <img src="{{ $product->product_image_url }}" alt="{{ $product->name }}" class="object-center object-cover">
        </div>
        <div class="flex-1 flex flex-col justify-between">
            <hgroup>
                <h4 class="text-lg/6 font-bold">{{ $product->name }}</h4>
                <p class="mt-0.5">
                    {{ $product->size }} {{ $product->size_unit }}
                </p>
                @if ($quantity > 1)
                    <p class="mt-1 text-sm text-stone-600">
                        {{ $product->formatted_price }} po kom.
                    </p>
                @endif

                <div class="mt-2 flex md:hidden gap-x-1">
                    <p class="text-base md:text-[1.5rem]/9 tracking-tight">
                        {{ number_format(($product->price * $quantity) / 100, 2, ',', '.') }}
                    </p>
                    <p class="text-sm/7 tracking-tight">RSD</p>
                </div>
            </hgroup>

            <div class="flex items-center gap-x-6">
                <div
                    class="inline-flex items-center bg-white rounded-full gap-x-1 overflow-hidden border border-stone-600">
                    <button type="button" wire:click="decrement()" wire:loading.attr="disabled"
                        @disabled($quantity === 0) aria-label="Decrease quantity by 1"
                        class="py-2 px-2.5 rounded-l-full disabled:cursor-not-allowed disabled:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                        </svg>
                    </button>
                    <span class="tabular-nums">{{ $quantity }}</span>
                    <button type="button" wire:click="increment()" wire:loading.attr="disabled"
                        @disabled($quantity === $product->stock) aria-label="Increase quantity by 1"
                        class="py-2 px-2.5 rounded-r-full disabled:cursor-not-allowed disabled:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>

                <button type="button" wire:click="remove()" wire:loading.attr="disabled"
                    class="text-base/7 underline text-stone-600 underline-offset-8">
                    Ukloni
                </button>
            </div>
        </div>
    </div>

    <div class="pt-3 hidden md:block">
        <div class="flex gap-x-1">
            <p class="text-[1.5rem]/9 tracking-tight">
                {{ number_format(($product->price * $quantity) / 100, 2, ',', '.') }}
            </p>
            <p class="text-sm/7 tracking-tight">RSD</p>
        </div>
    </div>
</div>
