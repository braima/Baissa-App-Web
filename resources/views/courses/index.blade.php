<?php $page = 'courseencours'; ?> 
@extends('layouts.app')
    
@section('content')

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-absolute fixed-top navbar-transparent">
      <div class="container-fluid">
        <div class="navbar-wrapper">
          <div class="navbar-toggle">
            <button type="button" class="navbar-toggler">
              <span class="navbar-toggler-bar bar1"></span>
              <span class="navbar-toggler-bar bar2"></span>
              <span class="navbar-toggler-bar bar3"></span>
            </button>
          </div>
          <a class="navbar-brand" href="#pablo">Liste des Course en cours</a>
        </div>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-bar navbar-kebab"></span>
          <span class="navbar-toggler-bar navbar-kebab"></span>
          <span class="navbar-toggler-bar navbar-kebab"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-end" id="navigation">
                
                    <ul class="navbar-nav">
                    <li class="nav-item btn-rotate dropdown">
                        <a class="nav-link dropdown-toggle" id="navbarDropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" style="cursor: pointer;">
                            <span class="currentName">{{ Auth::user()->name }}</span>
                            <i class="nc-icon nc-single-02"></i>
                            <p>
                                <span class="d-lg-none d-md-block">Some Actions</span>
                            </p>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                            @guest
                                <a class="dropdown-item" href="{{ route('login') }}">{{ __('Login') }}</a>
                                <!-- <a class="dropdown-item" href="#">Déconnecter</a> -->
                            @if (Route::has('register'))
                                <a class="dropdown-item" href="{{ route('register') }}">{{ __('Register') }}</a>
                            @endif
                            @else
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                            @endguest
                        </div>
                    </li>
                    </ul>
        </div>
      </div>
    </nav>

    <div class="content">
    @include('layouts.messages')
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <p>Total de courses: {{$count}}</p>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="myTable" class="table table-striped">
                                <thead>
                                        <tr>
                                            <th scope="col">Identifiant</th>
                                            <th scope="col">Chauffeur </th>
                                            <th scope="col">Location </th>
                                            <th scope="col">Destination </th>
                                            <th scope="col">Passengers </th>
                                            <th scope="col">Date </th>
                                            <th scope="col">Time </th>
                                            <th scope="col">Nom Complet </th>
                                            <th scope="col">Téléphone </th>
                                            <th scope="col">Prix </th>
                                            <th scope="col">Action </th>
                                        </tr>
                                </thead>
                                <tbody>
                                    @foreach ($reserv as $course)
                                        <tr>
                                            <td> {{ $course->Resid_FK}}</td>
                                            <td> {{ $course->id_chauffeur}}</td>
                                            <td> {{ $course->Location}}</td>
                                            <td> {{ $course->Destination  }}</td>
                                            <td> {{ $course->Passengers  }}</td>
                                            <td> {{ $course->Date }}</td>
                                            <td> {{ $course->time}}</td>
                                            <td> {{ $course->First_Name }} {{ $course->Family_Name }}</td>
                                            <td> {{ $course->Phone  }}</td>
                                            <td> {{ $course->price }}</td>
                                            <td><a href="{{ '/pmtfinal/courses/' . $course->id_course}}" class="btn btn-primary">Voir plus</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-10 d-flex justify-content-center">
                {{ $courses->links() }}
            </div>
        </div>
    </div>

<script>
  jQuery(document).ready(function($) {
      $('#myTable').DataTable({
          "order": [[ 0, "desc" ]],
         });
  });
</script>

@endsection