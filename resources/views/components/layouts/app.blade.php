<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    @livewireStyles
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="antialiased text-stone-900">
    <header class="bg-stone-100 w-full">
        <nav class="max-w-screen-xl px-6 w-full mx-auto flex items-center justify-between py-4">
            <a href="/" wire:navigate>
                <img src="{{ asset('images/logo.svg') }}" alt="{{ config('app.name') }}" class="h-10">
            </a>

            <div class="flex items-center gap-x-8">
                @auth
                    <form action="{{ route('logout') }}" method="POST" class="block">
                        @csrf
                        <button type="submit" class="text-sm font-bold">
                            Odjavi se
                        </button>
                    </form>
                @endauth

                @guest
                    <a href="/login" class="text-sm font-bold">
                        Prijavi se
                    </a>
                @endguest

                <livewire:cart-counter />
            </div>
        </nav>
    </header>

    <main class="max-w-screen-xl mx-auto px-6">
        {{ $slot }}
    </main>

    @livewireScriptConfig
</body>

</html>
