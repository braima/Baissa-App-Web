<?php $page = 'clients'; ?> 
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
                    <div>Clients</div>
                </div>
            </div>
        </div>

          @include('layouts.messages')
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                  <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#.</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>E-Mail</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($clients as $client)
                        <tr>
                          <td> {{ $client->id}}</td>
                          <td> {{ $client->name  }}</td>
                          <td> {{ $client->phone}}</td>
                          <td> {{ $client->email}}</td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>#.</th>
                          <th>Name</th>
                          <th>Phone</th>
                          <th>E-Mail</th>
                        </tr>
                      </tfoot>
                  </table>

                </div>
              </div>
            </div>
          </div>

      </div>
    </div>


@endsection