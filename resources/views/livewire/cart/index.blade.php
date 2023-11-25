<div>
    <h1 class="font-bold mt-12">Tvoja korpa ({{ $count }})</h1>

    <div class="mt-2 flex flex-col lg:flex-row gap-14 pb-16">
        <div class="flex-1 divide-y divide-stone-200 space-y-1">
            @forelse ($items as $cartItem)
                <livewire:cart.item :product="$cartItem->product" :quantity="$cartItem->quantity" :key="$cartItem->product->getKey() . microtime()" />
            @empty
                <p class="mt-5 text-sm text-stone-600">Korpa je prazna.</p>
            @endforelse
        </div>

        <div class="p-6 w-full shrink-0 md:max-w-sm bg-stone-100 rounded self-start md:min-h-[28.75rem]">
            <h2 class="font-bold">Tvoja narudžbina</h2>

            <ul class="mt-6 space-y-4">
                <li class="flex items-center justify-between">
                    <p>Ukupno</p>
                    <div class="flex gap-x-1">
                        <p class="text-lg/6 tracking-tight">
                            {{ $total }}
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
                        {{ $total }}
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
