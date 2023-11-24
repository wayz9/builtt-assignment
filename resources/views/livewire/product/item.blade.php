<div>
    <div class="relative bg-stone-100 flex items-center justify-center overflow-hidden group aspect-square">
        <img src="{{ $product->product_image_url }}" alt="{{ $product->name }}" class="object-center object-cover">

        <div x-data="{ qty: 1 }"
            class="absolute bottom-4 inset-x-0 group-hover:translate-y-0 translate-y-32 opacity-0 group-hover:opacity-100 transition-all duration-200 ease-in">
            <div class="px-4 flex items-center gap-x-2">
                <div class="flex items-center bg-white rounded-full gap-x-1 overflow-hidden">
                    <button type="button" x-on:click="if (qty > 1) qty--" :disabled="qty === 1"
                        aria-label="Decrease quantity by 1"
                        class="py-2 px-2.5 rounded-l-full disabled:cursor-not-allowed disabled:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                        </svg>
                    </button>
                    <span x-text="qty" class="tabular-nums"></span>
                    <button type="button" x-on:click="qty++" aria-label="Increase quantity by 1"
                        :disabled="{{ $product->isOutOfStock() ? 'true' : 'false' }} || qty ===
                            {{ $product->stock }}"
                        class="py-2 px-2.5 rounded-r-full disabled:cursor-not-allowed disabled:text-gray-400">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                        </svg>
                    </button>
                </div>
                <button type="button" aria-label="Add to cart" wire:click="addToCart(qty); qty = 1"
                    class="h-9 w-9 flex items-center justify-center rounded-full bg-stone-900 text-white">
                    <svg class="w-5 h-5" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M10.3716 1.66896L8.11852 4.17236L5.3685 7.17234L4.63135 6.49662L7.37979 3.49832L9.62828 1L10.3716 1.66896Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M12.6284 1.66896L14.8815 4.17236L17.6315 7.17234L18.3687 6.49662L15.6202 3.49832L13.3717 1L12.6284 1.66896Z"
                            fill="currentColor" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0 6.33449L3 21.3345H20L23 6.33449H0ZM1.2198 7.33449L3.8198 20.3345H19.1802L21.7802 7.33449H1.2198Z"
                            fill="currentColor" />
                    </svg>
                </button>
            </div>
            <input type="hidden" name="qty" :value="qty">
        </div>
    </div>

    <p class="mt-4 text-lg/6 font-bold tracking-tight">{{ $product->name }}</p>

    <div class="mt-2 flex items-start gap-x-1.5">
        <p class="text-[1.5rem]/8 tracking-tight">{{ $product->formatted_price }}</p>
        <span class="inline-flex text-xs">RSD</span>
    </div>
</div>
