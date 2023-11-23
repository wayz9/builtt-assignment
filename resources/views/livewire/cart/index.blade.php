<div>
    <h1 class="font-bold mt-12">Tvoja korpa</h1>

    <div class="mt-2 flex gap-x-14 pb-16">
        <div class="flex-1 divide-y divide-stone-200 space-y-1">
            @forelse ($cartItems as $product)
                <div class="py-5 flex">
                    <div class="flex gap-x-9 flex-1">
                        <div class="shrink-0 bg-stone-100 rounded flex items-center justify-center aspect-square w-36">
                            <img src="{{ $product->product_image_url }}" alt="a" class="object-center object-cover">
                        </div>
                        <div class="flex-1 flex flex-col justify-between">
                            <hgroup>
                                <h4 class="text-lg/6 font-bold">Naturela sa Rogačem i Agava Šećerom</h4>
                                <p class="mt-0.5">
                                    {{ $product->size }} {{ $product->size_unit }}
                                </p>
                                @if ($product->pivot->quantity > 1)
                                    <p class="mt-1 text-sm text-stone-600">
                                        {{ $product->formatted_price }} po kom.
                                    </p>
                                @endif
                            </hgroup>

                            <div class="flex items-center gap-x-6">
                                <div
                                    class="inline-flex items-center bg-white rounded-full gap-x-1 overflow-hidden border border-stone-600">
                                    <button type="button"
                                        wire:click="updateCartItem('{{ $product->getKey() }}', {{ $product->pivot->quantity - 1 }})"
                                        wire:loading.attr="disabled" @disabled($product->pivot->quantity === 0)
                                        aria-label="Decrease quantity by 1"
                                        class="py-2 px-2.5 rounded-l-full disabled:cursor-not-allowed disabled:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 12h-15" />
                                        </svg>
                                    </button>
                                    <span class="tabular-nums">{{ $product->pivot->quantity }}</span>
                                    <button type="button"
                                        wire:click="updateCartItem('{{ $product->getKey() }}', {{ $product->pivot->quantity + 1 }})"
                                        wire:loading.attr="disabled" @disabled($product->pivot->quantity === $product->stock)
                                        aria-label="Increase quantity by 1"
                                        class="py-2 px-2.5 rounded-r-full disabled:cursor-not-allowed disabled:text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M12 4.5v15m7.5-7.5h-15" />
                                        </svg>
                                    </button>
                                </div>

                                <button type="button" wire:click="removeFromCart('{{ $product->getKey() }}')"
                                    class="text-base/7 underline text-stone-600 underline-offset-8">
                                    Ukloni
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="pt-3">
                        <div class="flex gap-x-1">
                            <p class="text-[1.5rem]/9 tracking-tight">
                                {{ number_format(($product->price * $product->pivot->quantity) / 100, 2, ',', '.') }}
                            </p>
                            <p class="text-sm/7 tracking-tight">RSD</p>
                        </div>
                    </div>
                </div>
            @empty
                <p class="mt-5 text-sm text-stone-600">Korpa je prazna.</p>
            @endforelse
        </div>

        <div class="p-6 w-full shrink-0 max-w-sm bg-stone-100 rounded self-start min-h-[28.75rem]">
            <h2 class="font-bold">Tvoja narudžbina</h2>

            <ul class="mt-6 space-y-4">
                <li class="flex items-center justify-between">
                    <p>Ukupno</p>
                    <div class="flex gap-x-1">
                        <p class="text-lg/6 tracking-tight">
                            {{ $cartTotal }}
                        </p>
                        <p class="text-xs/5 tracking-tight">RSD</p>
                    </div>
                </li>
                <li class="flex items-center justify-between">
                    <p>Ušteda</p>
                    <div class="flex gap-x-1">
                        <p class="text-lg/6 tracking-tight">0.00</p>
                        <p class="text-xs/5 tracking-tight">RSD</p>
                    </div>
                </li>
                <li class="flex items-center justify-between">
                    <p>Isporuka Daily Express*</p>
                    <p class="text-sm text-stone-600">Besplatna</p>
                </li>
            </ul>

            <hr class="mt-3 mb-5">

            <div class="flex items-center justify-between">
                <p>Ukupno</p>
                <div class="flex gap-x-1">
                    <p class="text-lg/6 tracking-tight">
                        {{ $cartTotal }}
                    </p>
                    <p class="text-xs/5 tracking-tight">RSD</p>
                </div>
            </div>

            <p class="mt-2 text-sm text-stone-500">Cena je sa uključenim PDV-om</p>

            <button type="button" class="mt-8 block w-full bg-stone-950 rounded-full text-lg py-2 text-white">
                Prijavi se za brže plaćanje
            </button>
        </div>
    </div>
</div>
