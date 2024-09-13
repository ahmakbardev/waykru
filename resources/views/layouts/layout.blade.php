<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>WAYKRU</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <!-- Append version number to CSS file name -->
    <link rel="stylesheet" href="{{ asset('css/app.css?v=1.11') }}">
    <!-- Add cache-control headers for CSS and JavaScript files -->
    <link rel="preload" href="{{ asset('css/app.css?v=1.11') }}" as="style" crossorigin="anonymous" />
    <link href="{{ asset('styles-waykru/footer.css') }}" rel="stylesheet">
    <link href="{{ asset('styles-waykru/general.css') }}" rel="stylesheet">
    <link href="{{ asset('styles-waykru/header.css') }}" rel="stylesheet">
    <link href="{{ asset('styles-waykru/page-1.css') }}" rel="stylesheet">
    <link href="{{ asset('styles-waykru/page-2.css') }}" rel="stylesheet">
    <link href="{{ asset('styles-waykru/page-3.css') }}" rel="stylesheet">
    <link href="{{ asset('styles-waykru/page-4.css') }}" rel="stylesheet">

    @yield('assets')

</head>

<body class="antialiased">
    <script src="{{ asset('js/app.js') }}"></script> <!-- Pastikan sudah dicompile dengan Laravel Mix -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
        integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    @include('layouts.components.header')

    <main>
        @yield('content')
    </main>

    @include('layouts.components.footer')

    @include('layouts.components.toast')
    @include('layouts.components.chat-menu')

    <!-- Feather Icons CDN -->
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>


    <!-- Feather Replace Script -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            feather.replace();
        });
    </script>
</body>

</html>
