<?php $page = 'dashboard'; ?>  
@extends('layouts.appmain')

@section('assets')
  <style>
  </style>
@endsection

@section('content')

    <div class="container maindashboard">
        <div class="card-deck">
            
            <div class="row" style="width: 100%;">
                <div class="col-md-2"></div>

                <div class="col-md-4">
                    <div class="card">
                        @if(Auth::user()->subuser_id == 0)
                        <a href="/crm/commandes">
                            <img class="card-img-top" src="{{ asset('images/plateform.png') }}" alt="Card image cap">
                            <div class="card-body">
                                <h5 class="card-title">Tableau de bord</h5>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card">
                        @if(Auth::user()->role_id == 1 && Auth::user()->subuser_id == 0)
                        <a href="/crm/dashboardadmin">
                            <img class="card-img-top" src="{{ asset('images/superuser.png') }}" alt="Card image cap">
                            <div class="card-body">
                            <h5 class="card-title">Administration </h5>
                            </div>
                        </a>
                        @endif
                    </div>
                </div>

                <div class="col-md-2"></div>
                
            </div>

        </div>
    </div>
     
@endsection

@section('script')

@endsection