@extends('layouts.frontend.app')

@push('css')
@endpush

@section('content')

  @include('layouts.frontend.partial.header')

    <!-- About Us -->
    <section id="about" class="about section-padding" data-scroll-index="1">
        <div class="container">
            <div class="row">
                <div class="col-md-5">
                    <div class="about-img mb-30 img-fluid animate-box" data-animate-effect="fadeInLeft" style="background-image: url({{ asset('assets/img/about.jpg') }});">
                    </div>
                </div>
                <div class="col-md-7 animate-box" data-animate-effect="fadeInLeft">
                    <div class="title"> <span>À PROPOS DE</span>
                        <h2>Baissa</h2>
                        <hr class="line line-hr-secondary">
                    </div>
                    <p>
                        BAISSA est une marque de beauté de premier plan dans le GRAND MAROC, un multiconglomérat prospère avec Centre Baissa, Baissa Cosmètique, et Baissa Fashion.
                    </p>
                    <p>
                        BAISSA FASHION  est une entreprise avec des individus talentueux et créatifs qui se consacrent à servir nos clients avec le plus grand soin et l'excellence du service. Nous sommes fiers de nos employés en tant que force puissante derrière notre succès, grâce à laquelle le groupe a évolué pour devenir une marque de luxe de premier plan dans le monde de la beauté.
                    </p>
                    <p>
                    Nous avons constamment défié l'industrie de la beauté en apportant des innovations et les plus modernes dans ce que l'industrie a à offrir. Cela a conduit BAISSA à collaborer avec de grandes marques de beauté soigneusement sélectionnées, offrant ainsi des solutions sur mesure pour chaque besoin de beauté. Nous visons à exceller dans tout ce que nous faisons, notre objectif reste toujours d'aider la femme à trouver sa beauté intérieure et sa confiance en elle.                    </p>
                    <!-- <br />
                    <div class="row awards">
                        <div class="col-md-12">
                            <div class="title"> <span>Récompenses</span> </div>
                        </div>
                        <div class="col-md-12 owl-carousel owl-theme">
                            <div class="awards-logo">
                                <a href="#"><img src="{{ asset('assets/img/awards/1.jpg') }}" alt=""></a>
                            </div>
                            <div class="awards-logo">
                                <a href="#"><img src="{{ asset('assets/img/awards/2.jpg') }}" alt=""></a>
                            </div>
                            <div class="awards-logo">
                                <a href="#"><img src="{{ asset('assets/img/awards/3.jpg') }}" alt=""></a>
                            </div>
                            <div class="awards-logo">
                                <a href="#"><img src="{{ asset('assets/img/awards/4.jpg') }}" alt=""></a>
                            </div>
                            <div class="awards-logo">
                                <a href="#"><img src="{{ asset('assets/img/awards/5.jpg') }}" alt=""></a>
                            </div>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </section>
    <hr class="line-vr-section">    
    <!-- Portfolio -->
    <section id="portfolio " class="section-padding bg-grey" data-scroll-index="2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="title mb-30"> <span>Galerie</span>
                        <h2 class="animate-box" data-animate-effect="fadeInLeft">Portfolio</h2>
                        <hr class="line line-hr-secondary">
                    </div>
                </div>
            </div>
            <div class="row mb-30">
                <div class="col-md-4 gallery-item">
                    <a href="{{ asset('assets/img/portfolio/p1.png') }}" title="Fashion Makeup" class="img-zoom">
                        <div class="gallery-box">
                            <div class="gallery-img"> <img src="{{ asset('assets/img/portfolio/p1.png') }}" class="img-fluid mx-auto d-block" alt=""> </div>
                            <div class="gallery-detail text-center"> <i class="ti-plus"></i> </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 gallery-item">
                    <a href="{{ asset('assets/img/portfolio/p2.png') }}" title="Eye Makeup" class="img-zoom">
                        <div class="gallery-box">
                            <div class="gallery-img"> <img src="{{ asset('assets/img/portfolio/p2.png') }}" class="img-fluid mx-auto d-block" alt=""> </div>
                            <div class="gallery-detail text-center"> <i class="ti-plus"></i> </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 gallery-item">
                    <a href="{{ asset('assets/img/portfolio/p4.jpg') }}" title="Bridal Makeup" class="img-zoom">
                        <div class="gallery-box">
                            <div class="gallery-img"> <img src="{{ asset('assets/img/portfolio/p4.jpg') }}" class="img-fluid mx-auto d-block" alt=""> </div>
                            <div class="gallery-detail text-center"> <i class="ti-plus"></i> </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 gallery-item">
                    <a href="{{ asset('assets/img/portfolio/p3.jpg') }}" title="Painting Makeup" class="img-zoom">
                        <div class="gallery-box">
                            <div class="gallery-img"> <img src="{{ asset('assets/img/portfolio/p3.jpg') }}" class="img-fluid mx-auto d-block" alt=""> </div>
                            <div class="gallery-detail text-center"> <i class="ti-plus"></i> </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 gallery-item">
                    <a href="{{ asset('assets/img/portfolio/p5.jpg') }}" title="Effect Makeup" class="img-zoom">
                        <div class="gallery-box">
                            <div class="gallery-img"> <img src="{{ asset('assets/img/portfolio/p5.jpg') }}" class="img-fluid mx-auto d-block" alt=""> </div>
                            <div class="gallery-detail text-center"> <i class="ti-plus"></i> </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-4 gallery-item">
                    <a href="{{ asset('assets/img/portfolio/p6.jpg') }}" title="Fashion Makeup" class="img-zoom">
                        <div class="gallery-box">
                            <div class="gallery-img"> <img src="{{ asset('assets/img/portfolio/p6.jpg') }}" class="img-fluid mx-auto d-block" alt=""> </div>
                            <div class="gallery-detail text-center"> <i class="ti-plus"></i> </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </section>

  @include('layouts.frontend.partial.footer')

@endsection

@push('js')
	
@endpush
