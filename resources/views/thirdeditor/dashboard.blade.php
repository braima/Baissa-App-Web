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
                <a href="/thirdeditor/seances">
                    <img class="card-img-top" src="{{ asset('images/center.png') }}" alt="Card image cap">
                    <div class="card-body">
                        <h5 class="card-title">Centre Baissa</h5>
                    </div>
                </a>
            </div>
            <div class="card">
                
            </div>
            <div class="card">
                
            </div>
            <div class="card">
            </div>
            </div>
        </div>
    </div>
     
@endsection

@section('script')

@endsection