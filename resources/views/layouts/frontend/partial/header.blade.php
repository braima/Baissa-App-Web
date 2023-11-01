<!-- Navbar -->
<nav class="navbar navbar-expand-lg">
        <div class="container">
            <!-- Logo -->
            @if(request()->is('/'))
            <a class="logo animate-box" data-animate-effect="fadeInLeft" href="./"> <img src="{{ asset('assets/img/logo-light.png') }}" alt=""> </a>
            @else
            <a class="logo animate-box" data-animate-effect="fadeInLeft" href="./"> <img src="{{ asset('assets/img/logo-dark.png') }}" alt=""> </a>
            @endif
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"> <span class="icon-bar"><i class="ti-line-double"></i></span> </button>
            <!-- Navbar links -->
            <div class="collapse navbar-collapse animate-box" data-animate-effect="fadeInLeft" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item"><a class="nav-link {{ Request::is ('about') ? 'active' : null }}" href="{{ route('about') }}">À propos</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::is ('products') ? 'active' : null }}" href="{{ route('products') }}">Produits</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::is ('reservation') ? 'active' : null }}" href="{{ route('reservation') }}">Rendez-vous</a></li>
                    <li class="nav-item"><a class="nav-link {{ Request::is ('contact') ? 'active' : null }}" href="{{ route('contact') }}">Contactez-Nous</a></li>
                </ul>
            </div>
        </div>
    </nav>