<button {{ $attributes->merge([
    'class' => 'block w-full bg-stone-950 rounded-full text-lg py-2 text-white',
]) }}>
    {{ $slot }}
</button>
