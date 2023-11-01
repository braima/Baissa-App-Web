<?php $page = 'courseencours'; ?> 
@extends('layouts.app')

@section('assets')

	<style>
	    h6.smallHead {
            border-bottom: 1px solid #f4f3ef;
            padding-bottom: 10px;
            margin-bottom: 20px;
	    }
	</style>
	
@endsection

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
          <a class="navbar-brand" href="#pablo">Modification de Course Selectionné: {{$course->Resid_FK}}</a>
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
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 pr-1">
                        <h6 class="smallHead">Information Chauffeur:</h6>
                        <b style="padding-bottom: 20px; display: block;">
                            &diams; Ancien chauffeur : {{$course->id_chauffeur}} <br>
                            
                            <?php $pos=0; ?>
                            @foreach ($result as $results)
                                @if($results->id_chauffeur == $course->id_chauffeur)
                                    <?php $pos++ ?>
                                @endif
                            @endforeach  
                            &diams; Nombre de courses : <?php echo $pos ?>
                        </b>
                    </div>
                    <div class="col-md-6 pl-1">
                        <h6 class="smallHead">Modifier le chauffeur Actuel:</h6>
                        <form action="{{ '/pmtfinal/courses/' . $course->id_course}}" method="POST" style="width:100%">
                            @csrf
                            @method('PUT')
                            
                            <select name="id_chauffeur" id="id_chauffeur" class="form-control">
                                @foreach ($users as $user)
                                    <option value="{{ $user->name }}">{{ $user->name }} </option>
                                @endforeach 
                            </select>
                            <br>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Modifier</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
            
        <div class="card">
            <div class="card-header">
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12" style="">
                        <h6 class="smallHead">Informations de Courses affectée à : {{$course->id_chauffeur}}</h6>
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                <th scope="col">ID </th>
                                <th scope="col">Client </th>
                                <th scope="col">Location </th>
                                <th scope="col">Destination </th>
                                <th scope="col">Passengers </th>
                                <th scope="col">Date </th>
                                <th scope="col">Prix </th>
                                <th scope="col">Status </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($result as $results)
                                    @if($results->id_chauffeur == $course->id_chauffeur)
                                        @foreach($reservations as $reservation)
                                            @if($results->Resid_FK == $reservation->ID)
                                            <tr>
                                            <td> {{ $reservation->ID }}</td>
                                            <td> {{ $reservation->First_Name }} {{ $reservation->Family_Name }}</td>
                                            <td> {{ $reservation->Location }} </td>
                                            <td> {{ $reservation->Destination }} </td>
                                            <td> {{ $reservation->Passengers }} </td>
                                            <td> {{ $reservation->Date }} </td>
                                            <td> {{ $reservation->price }} </td>
                                            <td> {{ $results->statutCourses }}</td>
                                            </tr>
                                            @endif
                                        @endforeach
                                    @endif
                                @endforeach  
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

<script>
  jQuery(document).ready(function($) {
      $('#myTable').DataTable();
  });
</script>

@endsection