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
          <a class="navbar-brand" href="#pablo">Modification de Course ID: <b>{{ $course->Resid_FK }}</b></a>
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

    <div class="card">
        <div class="card-header">
            Course ID: {{ $course->Resid_FK }}
        </div>
        <div class="card-body" style="padding-top: 20px;">
        <table>
            <tr>
                <td style="padding-right:20px;"><span class="card-title"><b>Chauffeur:</b></span></td>
                <td><b>{{ $course->id_chauffeur }}</b></td>
            </tr>
            @foreach ($reservations as $reservation)
            <?php $ids = 0 ?>
            @if($reservation->ID == $course->Resid_FK)
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Location:</span></td>
                <td> {{ $reservation->Location}}</td>
            </tr>
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Destination:</span></td>
                <td> {{ $reservation->Destination}}</td>
            </tr>
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Passengers:</span></td>
                <td> {{ $reservation->Passengers}}</td>
            </tr>
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Date:</span></td>
                <td> {{ $reservation->Date}}</td>
            </tr>
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Time:</span></td>
                <td> {{ $reservation->time}}</td>
            </tr>
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Company:</span></td>
                <td> {{ $reservation->company}}</td>
            </tr>
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Flight number:</span></td>
                <td> {{ $reservation->Flight_number}}</td>
            </tr>
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Pickup address:</span></td>
                <td> {{ $reservation->pickup_address}}</td>
            </tr>
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Nom Complet:</span></td>
                <td> {{ $reservation->First_Name }} {{ $reservation->Family_Name }}</td>
            </tr>
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Téléphone:</span></td>
                <td> {{ $reservation->Phone}}</td>
            </tr>
            <tr>
                <td style="padding-right:20px;"><span class="card-title">Prix:</span></td>
                <td> {{ $reservation->price}}</td>
            </tr>
            @endif
            @endforeach
        </table>

            <hr>
            <small><span>{{  $course->created_at }}</span></small>
            <a href="{{ '/pmtfinal/courses/' . $course->id_course . '/edit'}}" class="btn btn-primary float-left mr-2">Edit</a>
            <form action="{{route('courses.destroy', ['id_course' => $course->id_course])}}" method="POST" style="display: inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger float-left">Delete</button>
            </form>
        </div>
    </div>

    </div>
@endsection