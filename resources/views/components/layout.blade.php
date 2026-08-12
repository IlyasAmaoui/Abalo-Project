<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - Abalo' : 'Abalo' }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.6/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4Q6Gf2aSP4eDXB8Miphtr37CMZZQ5oXLH2yaXMJ2w8e2ZtHTl7GptT4jmndRuHDT" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    @vite('resources/js/app.js')
</head>


<body>

<x-navbar :cart-count="session('cart_count', 0)" />





<@if (session('success'))
    <div class="fixed top-4 left-1/2 -translate-x-1/2 z-[9999]">
        <div class="flex items-center gap-3 rounded-xl px-5 py-3 shadow-lg
                    bg-[#598b6e] text-white
                    animate-fade-out">

            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-6 w-6 shrink-0"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"
                />
            </svg>

            <span class="text-sm font-medium">
                {{ session('success') }}
            </span>

        </div>
    </div>
@endif




<main class="flex-1 container mx-auto px-4 py-8">
    {{ $slot }}
</main>


<footer class="footer footer-center p-5 bg-base-300 text-base-content text-xs">
    <div>
        <p>© 2026 Abalo - Built with Laravel and ❤️</p>
    </div>
</footer>

</body>
</html>
