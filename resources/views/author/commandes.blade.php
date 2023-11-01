<?php $page = 'commandes'; ?> 
@extends('layouts.appAuthor')

@section('assets')
  <style>
    .page-title-heading.addCat {
      right: 0;
      position: absolute;
    }
    .addCat .page-title-icon {
      margin: 0 !important;
    }
    label {
      font-size: 15px;
      margin: 15px 0 0 0;
    } 
    a{
      cursor: pointer;
    }
  </style>
@endsection

@section('content')
      
    <div class="app-main__outer seances">
      <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-user icon-gradient bg-mean-fruit">
                        </i>
                    </div>
                    <div>Commandes</div>
                </div>
            </div>
        </div>

          @include('layouts.messages')
          <div class="row" style="margin-bottom:20px;">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                  <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#.</th>
                          <th style="width: 120px;">Client</th>
                          <th>Téléphone</th>
                          <th>Adresse</th>
                          <th>Montant Dhs</th>
                          <th>Paiement</th>
                          <th>Date</th>
                          <th>statut</th>
                          <th style="width: 200px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($commandes as $commande)
                        @if($commande->status == 0)
                        <tr>
                          <td> {{ $commande->id}}</td>
                          <td> {{ $commande->client_nom }}</td>
                          <td> {{ $commande->client_tel }}</td>
                          <td> {{ $commande->client_adresse }}</td>
                          <td> {{ $commande->total_ttc }}</td>
                          <td> {{ $commande->type_livraison}}</td>
                          <td> {{ date('d-m-Y', strtotime($commande->created_at))}}</td>
                          <td>
                            @if($commande->status == 0)
                              <a class="btn btn-danger" data-toggle="modal" data-target="#status{{ $commande->id }}" style="color: #fff;"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>
                              <div class="modal fade" id="status{{ $commande->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                  <div class="modal-content" style="text-align: center;">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous changer le status ?</h5>
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{'/user/commandestatus/' . $commande->id}}" method="get"  style="display: inline-block;">
                                        {{ csrf_field() }}
                                        <input type="text" name="statustochange" value="1" hidden>
                                        <button type="submit" class="btn btn-success">Valider</button>
                                        <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @else
                              <a class="btn btn-success" data-toggle="modal" data-target="#status{{ $commande->id }}" style="color: #fff;"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>
                              <div class="modal fade" id="status{{ $commande->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                  <div class="modal-content" style="text-align: center;">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous changer le status ?</h5>
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{'/user/commandestatus/' . $commande->id}}" method="get"  style="display: inline-block;">
                                        {{ csrf_field() }}
                                        <input type="text"  name="statustochange" value="0" hidden>
                                        <button type="submit" class="btn btn-danger">Réinitialiser</button>
                                        <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endif
                          </td>
                          <td>
                            <a class="btn btn-info" data-toggle="modal" data-target="#details{{ $commande->id }}"><i class="fa fa-eye text-light" aria-hidden="true"></i></a>
                            <div class="modal fade" id="details{{ $commande->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel">Produits demandées</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                      <span aria-hidden="true">&times;</span>
                                    </button>
                                  </div>

                                    <table class="table">
                                      <thead class="theadstyle">
                                        <tr>
                                          <th scope="col">Image. </th>
                                          <th scope="col">Produit</th>
                                          <th scope="col">Prix Unitaire</th>
                                          <th scope="col">Quantité</th>
                                          <th scope="col">Sub. Total</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach($datas as $data)
                                        @if($data->id_commande == $commande->id)
                                          <tr>
                                            <td><img src="{{ asset('produits/images/' .$data->photo) }}" width="100px;" height="100px;"></td>
                                            <td>{{$data->label}}</td>
                                            <td>{{$data->prix_unitaire}} Dhs</td>
                                            <td>{{$data->quantite}} </td>
                                            <td>{{$data->montant}} Dhs</td>
                                          </tr>
                                        @endif
                                        @endforeach
                                        <tr>
                                          <td>Total</td>
                                          <td>-</td>
                                          <td>-</td>
                                          <td>-</td>
                                          <td><b>{{ $commande->total_ttc }} Dhs</b></td>
                                        </tr>
                                      </tbody>
                                    </table>

                                </div>
                              </div>
                            </div>

                            <a class="btn btn-primary" href="{{ url('/user/commandeedit/'.$commande->id) }}"><i class="fa fa-cog text-light" aria-hidden="true"></i></a>

                            <a class="btn btn-warning" data-toggle="modal" data-target="#cancelcmd{{ $commande->id }}" style="color: #fff;"><i class="fa fa-undo" aria-hidden="true"></i></a>
                            <div class="modal fade" id="cancelcmd{{ $commande->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="text-align: center;">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous annuler la commande ?</h5>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{'/user/commandestatus/' . $commande->id}}" method="get"  style="display: inline-block;">
                                      {{ csrf_field() }}
                                      <input type="text" name="statustochange" value="2" hidden>
                                      <button type="submit" class="btn btn-danger">Annuler la commande</button>
                                      <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>

                            @if(Auth::user()->role_id == 1)
                            <a class="btn btn-danger" data-toggle="modal" data-target="#destroy{{ $commande->id }}" style="color: #fff;"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <div class="modal fade" id="destroy{{ $commande->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="text-align: center;">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous effectuer la suppression ?</h5>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{'/user/commandes/destroycmd/' . $commande->id}}" method="POST"  style="display: inline-block;">
                                      {{ csrf_field() }}
                                      <button type="submit" class="btn btn-danger">Supprimer</button>
                                      <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div> 
                            @endif
                          </td>
                        </tr>
                        @endif
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>#.</th>
                          <th style="width: 120px;">Client</th>
                          <th>Téléphone</th>
                          <th>Adresse</th>
                          <th>Montant Dhs</th>
                          <th>Paiement</th>
                          <th>Date</th>
                          <th>statut</th>
                          <th style="width: 200px;">Action</th>
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

@push('js')
  <script>
    (function() {
      'use strict';
      window.addEventListener('load', function() {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.getElementsByClassName('needs-validation');
        // Loop over them and prevent submission
        var validation = Array.prototype.filter.call(forms, function(form) {
          form.addEventListener('submit', function(event) {
            if (form.checkValidity() === false) {
              event.preventDefault();
              event.stopPropagation();
            }
            form.classList.add('was-validated');
          }, false);
        });
      }, false);
    })();
  </script>
@endpush