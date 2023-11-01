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

    @yield('assets')
    
</head>
<body  id="main-homepage">
    
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
                    <li class="nav-item btn-rotate dropdown <?php if($page == 'vosreservations' || $page == 'reservationsp'){echo 'active';} ?>">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink02" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                        <i class="nc-icon nc-bullet-list-67"></i>
                            <p style="display: inline-block;padding-right: 15px;">Réservations</p>
                        </a>
                        <div id="bookSubMenu" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink02">
                            <a href="/pmtfinal/entreprise/dashboard/MyBooks" class="list-group-item <?php if($page == 'vosreservations'){echo 'active';} ?>" data-parent="#sub-menu">
                                <i class="nc-icon nc-minimal-right"></i>  
                                Vos réservations
                            </a>
                            <a href="/pmtfinal/entreprise/dashboard/bookSPEntreprise" class="list-group-item <?php if($page == 'reservationsp'){echo 'active';} ?>" data-parent="#sub-menu">
                                <i class="nc-icon nc-minimal-right"></i>  
                                Réservations S.P
                            </a>
                        </div>
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
   
    @yield('script')

</body>
</html>

