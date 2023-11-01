@extends('layouts.frontend.app')

@push('css')
<style>
    .form-control{
        -webkit-appearance:auto !important;
        appearance: auto !important;  
    }
</style>
@endpush

@section('content')

  @include('layouts.frontend.partial.header')
        
    <section id="reservation" class="reservation section-padding ">

      <div class="container">

        <div class="row gx-0">
          <div class="col-lg-12 d-flex flex-column justify-content-center text-center">
            <div class="content">
              <h1><span> Rendez-vous</span></h1>
            </div>
          </div>
        </div>

        <div class="row gx-0">
        @include('layouts.messages')
          <form id="contact-form" class="contact-form row g-3 needs-validation" action="saverdv" method="post" style="width: 100%;">
            @csrf
            <div class="col-md-8">
              <input type="text" class="form-control" id="fullname" name="fullname" placeholder="Nom Complet" required>
            </div>
            <div class="col-md-4">
              <input type="number" class="form-control" name="phone" id="phone" placeholder="Téléphone" required>   
            </div>

            <hr style="margin-bottom: 2em;display: block;width: 100%;border: none;">

            <div class="col-md-4">
                <select class="form-control selectpicker countrypicker" name="ville" data-live-search="true" style="height: 80%;" required>
                    <option value="agadir">Agadir</option>
                    <option value="marrakech">Marrakech</option>
                    <option value="casablanca">Casa Blanca</option>
                </select>
            </div>

            <div class="col-md-4 text-left">
                <select class="form-control packageselected" name="pack" id="pack" style="height: 80%;" required>
                    <option disabled="true" selected="true">Sélectionner un package</option>
                    @foreach($packages->unique('pack') as $package)
                    <option value="{{$package->pack}}">{{$package->pack}}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-4">
                <select class="servicepack form-control" name="service" id="service" required></select>
            </div>

            <hr>

            <div class="col-12 text-center">
              <button class="btn btn-baissa-dark" type="submit">Valider votre Rendez-Vous</button>
            </div>
          </form>
        </div>

      </div>

    </section>

@include('layouts.frontend.partial.footer')

@endsection

@push('js')
<script type="text/javascript">
    $(document).ready(function(){

        $(document).on('change','.packageselected',function(){
            var cat_id=$(this).val();
            var productParent = $(this).parent().parent();
            var op=" ";
            var pt=" ";
            $.ajax({
                type:'get',
                url:'{!!URL::to('/findprixrdv')!!}',
                data:{'id':cat_id},
                success:function(data){

                    op+='';
                    pt+='';

                    for(var i=0;i<data.length;i++){
                        op+='<option value="'+data[i].label+'">'+data[i].label+'</option>';
                        pt = data[i].pu;
                    }
                    
                    productParent.find(".servicepack").html(" ");
                    productParent.find(".servicepack").append(op);                    
                },
                error:function(){
                }
            });

        });
    });
  </script>
@endpush