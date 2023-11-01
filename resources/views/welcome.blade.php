@extends('layouts.frontend.app')

@push('css')
@endpush

@section('content')
    
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo -->
            <a class="logo animate-box" data-animate-effect="fadeInLeft" href="./"> <img src="{{ asset('assets/img/logo-light.png') }}" alt=""> </a>
        </div>
    </nav>

    <header class="header valign bg-img parallaxie" data-scroll-index="0" data-overlay-dark="5" data-background="{{ asset('assets/img/slider.jpg') }}">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-left caption">
                    <hr class="line line-hr-primary animate-box" data-animate-effect="fadeInLeft">
                    <h5 class="animate-box" data-animate-effect="fadeInLeft">Femme d’affaire - Estheticienne - Makeup Artiste </h5>
                    <h1 class="animate-box" data-animate-effect="fadeInLeft">Meryem Baissa</h1> 
                    <a href="{{ route('products') }}" class="btn fl-btn animate-box" data-animate-effect="fadeInLeft">Produits</a>
                    <a href="{{ route('reservation') }}" class="btn fl-btn animate-box" data-animate-effect="fadeInLeft">Centre Baissa</a>
                    <a href="{{ route('inside') }}" class="btn fl-btn animate-box" data-animate-effect="fadeInLeft">Entre Website</a>
                </div>
            </div>
            <ul class="ovon-footer-social-link">
                <li><a href="https://www.facebook.com/Baissabeauty" target="_blank"><i class="ti-facebook"></i></a></li>
                <li><a href="https://www.instagram.com/meryam_baissa_officiel" target="_blank"><i class="ti-instagram"></i></a></li>
                <li><a href="https://www.tiktok.com/@meryambaissa" target="_blank"><i class="fab fa-tiktok"></i></a></li>
            </ul>
        </div>
        
    </header>

@endsection
@push('js')

@endpush




