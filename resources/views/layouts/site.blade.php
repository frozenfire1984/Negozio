<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
        
        @vite(['resources/css/site/index.scss'])
    </head>
    <body>
        <header class="header">
            <div class="container">
                <nav class="nav">
                    <ul>
                        <li><a href="/">Home</a></li>
                        <li><a href="/shopping-lists">Shopping List</a></li>
                        <li><a href="/shops">Shops</a></li>
                        <li><a href="/login" target="_blank">Login</a></li>
                    </ul>
                </nav>
            </div>
        </header>
        <main class="main">
            <div class="container">
                {{ $slot }}
            </div>
        </main>
        <footer class="footer">
            <div class="container">
                {{ config('app.name', 'Laravel') }}
            </div>
        </footer>
    </body>
</html>
