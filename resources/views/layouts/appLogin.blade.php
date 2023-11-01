<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    <title>{{ config('app.name', 'BAISSA') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">

    @stack('css') 

</head>
<body class="loginForm">
    
    <div class="app wrapper">

        <!-- Page Content  -->
        <div id="content">
            
            <main class="py-4 login">
                @include('layouts.messages')
                @yield('content')
            </main>

        </div>
    </div>

</body>

<script src="{{ asset('js/main.js') }}"></script>
</html>
