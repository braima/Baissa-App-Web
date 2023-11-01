<!DOCTYPE html>

<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="Content-Language" content="en">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no"/>
    <meta name="description" content="Wide selection of modal dialogs styles and animations available.">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="msapplication-tap-highlight" content="no">
    <title>{{ config('app.name', 'BAISSA') }}</title>

    <!-- Disable tap highlight on IE -->
    <meta name="msapplication-tap-highlight" content="no">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link rel="shortcut icon" href="{{ asset('images/favicon.ico') }}">

    @yield('assets')


    <!-- SIDEBAR -->
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet">
    <!-- <link rel="stylesheet"  href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.37/css/bootstrap-datetimepicker.min.css" /> -->

    @stack('css') 

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script> -->

</head>
<body>

    <div class="app-container app-theme-white body-tabs-shadow fixed-header fixed-sidebar">
        <div class="app-header header-shadow">
            <div class="app-header__logo">
                <a href="/"><div class="logo-src"></div></a>
                <div class="header__pane ml-auto">
                    <div>
                        <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="app-header__mobile-menu">
                <div>
                    <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                        <span class="hamburger-box">
                            <span class="hamburger-inner"></span>
                        </span>
                    </button>
                </div>
            </div>
            <div class="app-header__menu">
                <span>
                    <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                        <span class="btn-icon-wrapper">
                            <i class="fa fa-ellipsis-v fa-w-6"></i>
                        </span>
                    </button>
                </span>
            </div>    
            <div class="app-header__content">
                <div class="app-header-right">
                    <div class="header-btn-lg pr-0">
                        <div class="widget-content p-0">
                            <div class="widget-content-wrapper">
                                <div class="widget-content-left">
                                    <div class="btn-group">
                                        <a data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="p-0 btn">
                                            <img width="42" class="rounded-circle" src="{{ asset('images/avatars/1.jpg') }}" alt="">
                                            <i class="fa fa-angle-down ml-2 opacity-8"></i>
                                        </a>
                                        <div tabindex="-1" role="menu" aria-hidden="true" class="rm-pointers dropdown-menu-lg dropdown-menu dropdown-menu-right">
                                            <div class="dropdown-menu-header">
                                                <div class="dropdown-menu-header-inner bg-info">
                                                    <div class="menu-header-image opacity-2" style="background-image: url('assets/images/dropdown-header/city3.jpg');"></div>
                                                    <div class="menu-header-content text-left">
                                                        <div class="widget-content p-0">
                                                            <div class="widget-content-wrapper">
                                                                <div class="widget-content-left mr-3">
                                                                <img width="42" class="rounded-circle" src="{{ asset('images/avatars/1.jpg') }}" alt="">
                                                                </div>
                                                                <div class="widget-content-left">
                                                                    <div class="widget-heading">{{ Auth::user()->name }}
                                                                    </div>
                                                                    <div class="widget-subheading opacity-8">Administrateur
                                                                    </div>
                                                                </div>
                                                                <div class="widget-content-right mr-2">
                                                                    @guest
                                                                        <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="{{ route('login') }}">{{ __('Login') }}</a>
                                                                        <!-- <a class="dropdown-item" href="#">Déconnecter</a> -->
                                                                    @if (Route::has('register'))
                                                                        <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="{{ route('register') }}">{{ __('Register') }}</a>
                                                                    @endif
                                                                    @else
                                                                        <a class="btn-pill btn-shadow btn-shine btn btn-focus" href="{{ route('logout') }}"
                                                                            onclick="event.preventDefault();
                                                                            document.getElementById('logout-form').submit();">
                                                                            {{ __('Logout') }}
                                                                        </a>
                                                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                                                            @csrf
                                                                        </form>
                                                                    @endguest
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="widget-content-left  ml-3 header-user-info">
                                    <div class="widget-heading">
                                        {{ Auth::user()->name }}
                                    </div>
                                </div>
                                
                            </div>
                        </div>
                    </div>

                       
                </div>
            </div>
        </div>    
        
        <div class="app-main">
            <div class="app-sidebar sidebar-shadow">
                <div class="app-header__logo">
                    <a href="/"><div class="logo-src"></div></a>
                    <div class="header__pane ml-auto">
                        <div>
                            <button type="button" class="hamburger close-sidebar-btn hamburger--elastic" data-class="closed-sidebar">
                                <span class="hamburger-box">
                                    <span class="hamburger-inner"></span>
                                </span>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="app-header__mobile-menu">
                    <div>
                        <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                            <span class="hamburger-box">
                                <span class="hamburger-inner"></span>
                            </span>
                        </button>
                    </div>
                </div>
                <div class="app-header__menu">
                    <span>
                        <button type="button" class="btn-icon btn-icon-only btn btn-primary btn-sm mobile-toggle-header-nav">
                            <span class="btn-icon-wrapper">
                                <i class="fa fa-ellipsis-v fa-w-6"></i>
                            </span>
                        </button>
                    </span>
                </div> 
                <!-- ---------- START SIDEBAR ----------- -->                   
                <div class="scrollbar-sidebar" style="overflow: auto;">
                    <div class="app-sidebar__inner">
                        <ul class="vertical-nav-menu">
                            <!-- <a href="{{ url('/clear-cache') }}">clear cache</a> -->
                            <li class="app-sidebar__heading">Menu</li>
                            <!-- Dashboard Menu -->
                            <li>
                                <a href="/crm/dashboard" class="<?php if($page == 'dashboard'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-rocket"></i>
                                    Tableaux de bord
                                </a>
                            </li>
                            <!-- RDV -->
                            <li class="app-sidebar__heading">RDV</li>
                            <li>
                                <a href="/crm/rendezvous" class="<?php if($page == 'rendezvous'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-user"></i>Nouvelles
                                </a>
                            </li>
                            <li>
                                <a href="/crm/rendezvousvalidates" class="<?php if($page == 'rendezvousvalidates'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-back-2"></i>
                                    Validés
                                </a>
                            </li>
                            <li>
                                <a href="/crm/rendezvousannule" class="<?php if($page == 'rendezvousannule'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-next-2" style="padding-left: 9px;"></i>
                                    Annulés
                                </a>
                            </li>
                            <!-- Nouvelles Commandes -->
                            <li class="app-sidebar__heading">Nouvelles Commandes</li>
                            <li>
                                <a href="/crm/newcmd" class="<?php if($page == 'newcmd'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-upload" style="font-size: 2em;padding-left: 3px;"></i>
                                    Commandes
                                </a>
                            </li>
                            <li>
                                <a href="/crm/validatedcmd" class="<?php if($page == 'validatedcmd'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-back-2"></i>
                                    validée
                                </a>
                            </li>
                            <li>
                                <a href="/crm/canceledcmd" class="<?php if($page == 'canceledcmd'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-next-2" style="padding-left: 9px;"></i>
                                    Annulé
                                </a>
                            </li>
                            <!-- Séances -->
                            <li class="app-sidebar__heading">Séances</li>
                            <li>
                                <a href="/crm/seances" class="<?php if($page == 'seances'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-user"></i>Nouvelle
                                </a>
                            </li>
                            <li>
                                <a href="/crm/seanceseffectue" class="<?php if($page == 'seanceseffectue'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-user"></i>Effectués
                                </a>
                            </li>
                            <li>
                                <a href="/crm/seancesannules" class="<?php if($page == 'seancesannules'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-user"></i>Annulés
                                </a>
                            </li>
                            <!-- Catégories -->
                            <li class="app-sidebar__heading">Catégories</li>
                            <li>
                                <a href="/crm/categories" class="<?php if($page == 'categories'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-upload" style="font-size: 2em;padding-left: 3px;"></i>
                                    Etat Général
                                </a>
                            </li>
                            <!-- Produits -->
                            <li class="app-sidebar__heading">Produits</li>
                            <li>
                                <a href="/crm/produits" class="<?php if($page == 'produits'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-upload" style="font-size: 2em;padding-left: 3px;"></i>
                                    Etat Général
                                </a>
                            </li>
                            <!-- Contact -->
                            <li class="app-sidebar__heading">Contacts</li>
                            <li>
                                <a href="/crm/clients" class="<?php if($page == 'clients'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-user"></i>Clients
                                </a>
                            </li>
                            <!-- Activities  -->
                            <li class="app-sidebar__heading">Activités</li>
                            <li>
                                <a href="/crm/activities" class="<?php if($page == 'activities'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon pe-7s-ticket"></i>
                                    Traçabilité
                                </a>
                            </li>
                            <!-- Utilisateurs -->
                            <li class="app-sidebar__heading">Aide Et Paramètres</li>
                            <li>
                                <a href="/crm/utilisateurs" class="<?php if($page == 'utilisateurs'){echo 'mm-active';} ?>">
                                    <i class="metismenu-icon lnr-users"></i>Utilisateur
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <!------------ END SIDEBAR -------------- -->      
            </div>
            @yield('content')
        </div>
        
    </div>

    <div class="app-drawer-overlay d-none animated fadeIn"></div>

    <script src="{{ asset('js/main.js') }}"></script>

    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>

    <!-- @stack('js') -->
    @yield('script')
    
   

</body>
</html>
