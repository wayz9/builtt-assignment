<a href="{{ route('cart.index') }}" wire:navigate class="relative text-gray-800">
    <svg class="w-6 h-6" viewBox="0 0 23 23" fill="none" xmlns="http://www.w3.org/2000/svg">
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

    <span class="absolute left-1/2 -translate-x-1/2 top-1 text-sm font-medium">
        {{ $totalItems }}
    </span>
</a>
