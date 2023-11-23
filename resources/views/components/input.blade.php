@props(['name', 'type' => 'text', 'value' => null, 'id' => null, 'label' => null, 'required' => false])

<div {{ $attributes->merge(['class' => 'relative z-0']) }}>
    <input type="{{ $type }}" id="{{ $id ?? $name }}"
        class="block py-2.5 pt-6 px-0 w-full bg-transparent border-0 border-b border-stone-300 appearance-none focus:outline-none focus:ring-0 focus:border-stone-600 peer"
        placeholder=" " value="{{ $value }}" name="{{ $name }}" {{ $required ? 'required' : '' }} />
    <label for="email"
        class="absolute text-sm text-stone-600 duration-300 transform -translate-y-6 top-6 -z-10 origin-[0] peer-placeholder-shown:translate-y-0 peer-focus:-translate-y-6">
        {{ $label ?? Str::ucfirst($name) }}
    </label>
</div>
