<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />

    @yield('assets')

</head>
<body>
    <div class="app wrapper">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="logo">
                <a href="" class="simple-text logo-mini">
                    <div class="logo-image-small">
                    <img src="{{ asset('img/logo-small.png') }}">
                    </div>
                </a>
                <a href="" class="simple-text logo-normal">
                    Paris Magic Trip
                    <!-- <div class="logo-image-big">
                    <img src="../assets/img/logo-big.png">
                    </div> -->
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="<?php if($page == 'dashboard'){echo 'active';} ?>">
                        <a href="/pmtfinal/dashboard">
                            <i class="nc-icon nc-bank"></i>
                            <p>Tableau de bord</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        <div class="main-panel">
            @yield('content')
            <footer class="footer footer-black  footer-white ">
                <div class="container-fluid">
                <div class="row">
                    <div class="credits ml-auto">
                    <span class="copyright">
                        ©
                        <script>
                        document.write(new Date().getFullYear())
                        </script>, Tous les droits sont réservés 
                    </span>
                    </div>
                </div>
                </div>
            </footer>
        </div>

    </div>
   
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <!-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> -->
    <script src="{{ asset('js/perfect-scrollbar.jquery.min.js') }}"></script>
    <!-- Chart JS -->
    <script src="{{ asset('js/chartjs.min.js') }}"></script>
    <!--  Notifications Plugin    -->
    <script src="{{ asset('js/bootstrap-notify.js') }}"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="{{ asset('js/paper-dashboard.min.js?v=2.0.0') }}" type="text/javascript"></script>

    @yield('script')

</body>
</html>
