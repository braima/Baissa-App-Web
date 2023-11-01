@extends('layouts.frontend.app')

@push('css')
@endpush

@section('content')

  @include('layouts.frontend.partial.header')
    <!-- Slider -->
    <div id="carouselExampleFade" class="carousel slide carousel-fade insidepage" data-ride="carousel">
      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="{{ asset('assets/img/slider/02baissa.jpg') }}" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <p>Meryem Baissa - Femme d'affaire</p>
          </div>
        </div>
        <div class="carousel-item">
          <img src="{{ asset('assets/img/slider/01baissa.jpg') }}" class="d-block w-100" alt="...">
          <div class="carousel-caption d-none d-md-block">
            <p>Meryem Baissa - Makeup Artiste</p>
          </div>
        </div>
      </div>
      <a class="carousel-control-prev" href="#carouselExampleFade" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="sr-only">Previous</span>
      </a>
      <a class="carousel-control-next" href="#carouselExampleFade" role="button" data-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="sr-only">Next</span>
      </a>
    </div>

@endsection

@push('js')
	
@endpush
