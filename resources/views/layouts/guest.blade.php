<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-white">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Inkline</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=dm-sans:400,500,600|fraunces:600,700&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="h-full min-h-screen bg-white font-sans text-stone-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
            <div>
                <a href="{{ route('home') }}" class="font-display text-2xl font-semibold text-inkline-900">Inkline</a>
            </div>

            <div class="mt-6 w-full overflow-hidden border border-amber-100 bg-white px-6 py-4 shadow-lg shadow-amber-900/5 sm:max-w-md sm:rounded-xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
