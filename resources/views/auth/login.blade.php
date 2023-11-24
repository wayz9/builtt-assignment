<x-layouts.auth>
    <div class="max-w-[26.25rem] w-full px-4">
        <h1 class="text-xl font-bold">Prijavi se na svoj nalog</h1>
        <form action="{{ route('login') }}" method="POST" class="mt-8 block w-full">
            @csrf

            <x-input label="E-mail adresa" name="email" :value="old('email')" :required="true" />
            <x-input label="Upišite šifru" type="password" name="password" class="mt-6" :required="true" />

            <x-primary-button type="submit" class="mt-16">
                Prijavi se na nalog
            </x-primary-button>
        </form>

        @if ($errors->any())
            <ul class="mt-8 text-xs text-red-600 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        @endif
    </div>
</x-layouts.auth>
