<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <title>Laravel</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
