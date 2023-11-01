<?php $page = 'dashboardweb'; ?>  
@extends('layouts.appAuthor')

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
                <div class="card-body seancesexists">
                <b>{{ Auth::user()->name }},</b> Bienvenue au système Baissa.
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