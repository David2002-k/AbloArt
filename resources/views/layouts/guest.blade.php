<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="auth-page font-sans text-gray-900 antialiased">
        <div class="auth-shell flex min-h-screen flex-col items-center justify-center px-4 py-10">
            <div class="auth-brand-panel mb-6 text-center">
                <span class="auth-mark" aria-hidden="true">A</span>
                <div>
                    <a href="{{ route('welcome') }}" class="home-wordmark auth-wordmark" aria-label="AbloArt, accueil">Ablo<span>Art</span><i></i></a>
                    <p class="auth-tagline">Atelier de portraits personnalisés</p>
                </div>
            </div>

            <div class="auth-card w-full sm:max-w-md overflow-hidden px-6 py-7 sm:px-8">
                {{ $slot }}
            </div>

            <a href="{{ route('welcome') }}" class="auth-back mt-5">Retour à l'accueil</a>
        </div>
    </body>
</html>
