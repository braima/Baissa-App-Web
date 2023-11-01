<?php $page = 'tombola'; ?> 
@extends('layouts.appweb')
    
@section('content')
      
    <div class="app-main__outer">
      <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-user icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>TOMBOLA</div>
                </div>
            </div>
        </div>

          @include('layouts.messages')
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                  <table style="width: 100%;" class="table table-hover table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>Nom</th>
                          <th>Téléphone</th>
                          <th>N. Commandes</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($duplicatedRecords as $record)
                            <tr>
                                <td>{{$record->client_nom}}</td>
                                <td>{{$record->client_tel}}</td>
                                <td>{{$record->count}}</td>
                            </tr>
                        @endforeach
                      </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>

      </div>
    </div>


@endsection