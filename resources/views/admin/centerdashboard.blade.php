<?php $page = 'centerdashboard'; ?>  
@extends('layouts.appcenter')

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
                        <i class="pe-7s-car icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Tableaux de bord</div>
                </div>
            </div>
        </div>

        <div class="tabs-animation">
            <div class="card mb-3">
                <div class="card-header-tab card-header">
                    <div class="card-header-title font-size-lg text-capitalize font-weight-normal"><i class="header-icon lnr-laptop-phone mr-3 text-muted opacity-6"> </i>Liste des seances</div>
                </div>
                <div class="card-body seancesexists">
                <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#.</th>
                          <th>Client</th>
                          <th>Service</th>
                          <th>Montant Dhs</th>
                          <th>Avance Dhs</th>
                          <th>N° Séance</th>
                          <th>N° Effectuées</th>
                          <th>Date</th>
                          <th>Heure</th>
                          <th>Reste</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($seances as $seance)
                        @if($seance->status == 0)
                        <tr>
                          <td> {{ $seance->id}}</td>
                          <td> {{ $seance->name  }}</td>
                          <td> {{ $seance->package  }}</td>
                          <td> {{ $seance->price  }}</td>
                          <td> {{ $seance->avancement  }}</td>
                          <td> {{ $seance->nbrseance}}</td>
                          <td> {{ $seance->nbreffectue}}</td>
                          <td> {{ $seance->price - $seance->avancement}}</td>
                          <td> {{ $seance->date}}</td>
                          <td> {{ $seance->time}} : 00</td>
                        </tr>
                        @endif
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>#.</th>
                          <th>Client</th>
                          <th>Service</th>
                          <th>Montant Dhs</th>
                          <th>Avance Dhs</th>
                          <th>N° Séance</th>
                          <th>N° Effectuées</th>
                          <th>Date</th>
                          <th>Heure</th>
                          <th>Reste</th>
                          <th>Action</th>
                        </tr>
                      </tfoot>
                  </table>
                </div>
            </div>
        </div>
    </div>
  </div>
      
@endsection

@push('js')
  <script type="text/javascript">
    $(document).ready(function(){
      $(document).on('change','.packages',function(){
        var cat_id=$(this).val();
        var op=" ";
        var div=$(this).parent();
        $.ajax({
            type:'get',
            url:'{!!URL::to('/crm/findprixtotal')!!}',
            data:{'id':cat_id},
            success:function(data){
              op+='';
                for(var i=0;i<data.length;i++){
                    op+='<option value="'+data[i].pu+'" selected>'+data[i].pu+'</option>';
                }
                $('html').find('.prixtotal').html(" ");
                $('html').find('.prixtotal').append(op);
            },
            error:function(){
            }
        });
      });
    });
  </script>

  <script type="text/javascript">
    $(document).ready(function(){
      $(document).on('change','.packagetoken',function(){
        var cat_id=$(this).val();
        var op=" ";
        var div=$(this).parent();
        $.ajax({
            type:'get',
            url:'{!!URL::to('/crm/findpriceonupdate')!!}',
            data:{'id':cat_id},
            success:function(data){
              op+='';
                for(var i=0;i<data.length;i++){
                    op+='<option value="'+data[i].pu+'" selected>'+data[i].pu+'</option>';
                }
                $('html').find('.price').html(" ");
                $('html').find('.price').append(op);
            },
            error:function(){
            }
        });
      });
    });
  </script>
@endpush