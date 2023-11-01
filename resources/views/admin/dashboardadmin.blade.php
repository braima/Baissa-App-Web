<?php $page = 'dashboardweb'; ?>  
@extends('layouts.appadmin')

@section('assets')
  <style>
  </style>
@endsection

@section('content')

  <div class="app-main__outer">
    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-edit icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Tableaux de bord </div>
                </div>
            </div>
        </div>
        @include('layouts.messages')
        <div class="tabs-animation">
            <div class="card mb-3">
                <div class="card-body ">
                Bonjour Mr: <b>Super Administrateur</b>
                </div>
            </div>
        </div>
    </div>
  </div>
      
@endsection

@push('js')

@endpush