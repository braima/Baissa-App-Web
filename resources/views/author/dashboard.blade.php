<?php $page = 'dashboard'; ?>  
@extends('layouts.appmain')

@section('assets')
  <style>
  </style>
@endsection

@section('content')

    <div class="container maindashboard">
        <div class="card-deck">
            <div class="card">
                
            </div>
            <div class="card">
              
            </div>
            <div class="card">
                <a href="/user/dashboardweb">
                    <img class="card-img-top" src="{{ asset('images/plateform.png') }}" alt="Card image cap">
                    <div class="card-body">
                    <h5 class="card-title">Plateforme Web</h5>
                    </div>
                </a>
            </div>
            <div class="card">
            </div>
            </div>
        </div>
    </div>
     
@endsection

@section('script')

@endsection