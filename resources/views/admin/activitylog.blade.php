<?php $page = 'activities'; ?> 
@extends('layouts.appweb')

@push('css')
<style>
  
</style>
@endpush

@section('content')
      
    <div class="app-main__outer">
      <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-note2 icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Traçabilités</div>
                </div>
            </div>
        </div>

    <div class="content">
      @include('layouts.messages')
      <ul class="body-tabs body-tabs-layout tabs-animated body-tabs-animated nav">
        <li class="nav-item">
          <a role="tab" class="nav-link active" id="tab-0" data-toggle="tab" href="#tab-content-0">
            <span>RDV</span>
          </a>
        </li>
        <li class="nav-item">
          <a role="tab" class="nav-link" id="tab-3" data-toggle="tab" href="#tab-content-3">
            <span>Utilisateurs</span>
          </a>
        </li>
      </ul>
      <div class="tab-content">
        <div class="tab-pane tabs-animation fade show active" id="tab-content-0" role="tabpanel">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#.</th>
                          <th>Description</th>
                          <th>Causer</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($activities as $activity)
                          <tr>
                            <td> {{ $activity->id}}</td>
                            <td> {{ $activity->description}}</td>
                            <td> 
                                @foreach($users as $user)
                                  @if($user->id == $activity->causer_id)
                                    {{ $user->name}}
                                  @endif
                                @endforeach
                            </td>
                            <td>{{$activity->created_at}}</td>
                            <td>{{$activity->properties}}</td>
                          </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>#.</th>
                          <th>Description</th>
                          <th>Causer</th>
                          <th>Date</th>
                        </tr>
                      </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="tab-pane tabs-animation fade" id="tab-content-3" role="tabpanel">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">
                  <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#.</th>
                          <th>Description</th>
                          <th>Causer</th>
                          <th>Date</th>
                        </tr>
                      </thead>
                      <tbody>
                      @foreach ($utilisateurs as $utilisateur)
                        <tr>
                          <td> {{ $utilisateur->id}}</td>
                          <td> {{ $utilisateur->description}}</td>
                          <td> 
                              @foreach($users as $user)
                                @if($user->id == $utilisateur->causer_id)
                                  {{ $user->name}}
                                @endif
                              @endforeach
                          </td>
                          <td>{{$utilisateur->properties}}</td>
                        </tr>
                      @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>#.</th>
                          <th>Description</th>
                          <th>Causer</th>
                          <th>Date</th>
                        </tr>
                      </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

      </div>
    </div>

@endsection