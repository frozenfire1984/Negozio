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
        
        @vite(['resources/css/site/index.scss'])
    </head>
    <body>
        <header>
            <nav>
                <ul>
                    <li><a href="#">Home</a></li>
                    <li><a href="/shopping-lists">Shopping List</a></li>
                    <li><a href="/about">About</a></li>
                </ul>
            </nav>
        </header>
        <main>
            {{ $slot }}
        </main>
        <footer>
            {{ config('app.name', 'Laravel') }}
        </footer>
    </body>
</html>
