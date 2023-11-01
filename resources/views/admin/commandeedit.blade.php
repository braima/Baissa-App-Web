<?php $page = 'commandes'; ?> 
@extends('layouts.appweb')

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
    div.dataTables_wrapper div.dataTables_info {
      font-size: 10px;
    }
    div.dataTables_wrapper div.dataTables_paginate ul.pagination {
      font-size: 10px;
    }
    div#example_length {
      display: none;
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
                  <div>Détails du Commande</div>
              </div>
          </div>
      </div>
      @include('layouts.messages')

      <!-- commande -->
      <div class="row">
        <div class="col-md-6 mb-4">
          <div class="card">
            <div class="card-header">
              <h5>Commande</h5>
            </div>
            <div class="card-body">

              <table id="" class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">#. </th>
                    <th scope="col">Paiement</th>
                    <th scope="col">Date Commande</th>
                    <th scope="col">Prix. Total </th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{$commande->id}}</td>
                    <td>{{$commande->type_livraison}} </td>
                    <td>{{$commande->	created_at}}</td>
                    <td>{{$commande->total_ttc}} Dhs</td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div>
        </div>
        <div class="col-md-6 mb-4">
          <div class="card">
            <div class="card-header">
              <h5>Client</h5>
            </div>
            <div class="card-body">

              <table id="" class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Nom. </th>
                    <th scope="col">Téléphone</th>
                    <th scope="col">Adresse</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{$commande->client_nom}}</td>
                    <td>{{$commande->client_tel}}</td>
                    <td>{{$commande->client_adresse}}</td>
                  </tr>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>

      <!-- Produits -->
      <div class="row">
        <div class="col-md-12 mb-5">
          <div class="card">
            <div class="card-header">
              <h5 style="display: inline-block;">Produits</h5>
              <a class="btn btn-primary" data-toggle="modal" data-target="#addproduct" style="float: right;color:#fff;right: 20px;position: absolute;">Ajouter un Produit</a>
                <div class="modal fade" id="addproduct" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                  <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Ajouter un Produit</h5>
                      </div>
                      <div class="modal-body">
                        
                          <table id="example" class="table table-hover table-striped table-bordered w-100" >
                            <thead>
                              <tr>
                                <th scope="col">Photo. </th>
                                <th scope="col">Produit </th>
                                <th scope="col" class="processqte">Quantité  <span style="margin-left: 7em;">Action</span> </th>
                              </tr>
                            </thead>
                            <tbody>
                              @foreach($produits as $produit)
                              <tr>
                                <td><img src="{{ asset('produits/images/' .$produit->photo) }}" width="100px;" height="100px;"></td>
                                <td>{{$produit->label}}</td>
                                <td>
                                  <form action="{{ url('/crm/commandeedit/' .$commande->id . '/addpdtocmd/' .$produit->id) }}" method="POST">
                                    @csrf
                                    <input type="text" class="form-control inputleft" name="addqtepd" id="addqtepd" style="width: 85px;display: inline-block;" placeholder="Qte." required>
                                    <button type="submit" class="btn btn-primary" style="position: absolute;margin: 0.2em 0 0 7em;"><i class="fa fa-plus text-light"></i></button>
                                  </form>
                                </td>
                              </tr>
                              @endforeach
                            </tbody>
                          </table>
                        
                      </div>
                    </div>
                  </div>
                </div> 
            </div>
            <div class="card-body">
              <table id="myTable" class="table table-striped">
                <thead>
                  <tr>
                    <th scope="col">Photo. </th>
                    <th scope="col">Produit </th>
                    <th scope="col">Quantité</th>
                    <th scope="col">Prix Total</th>
                    <th scope="col">Action </th>
                  </tr>
                </thead>
                <tbody>
                  @php
                    $productstocount = count($datas)
                  @endphp
                  @foreach($datas as $data)
                  <tr>
                    <td><img src="{{ asset('produits/images/' .$data->photo) }}" width="100px;" height="100px;"></td>
                    <td>{{$data->label}}</td>
                    <td>{{$data->quantite}}</td>
                    <td>{{$data->montant}} Dhs</td>
                    <td>
                      <a class="btn btn-warning" data-toggle="modal" data-target="#update{{ $data->id_produit }}"><i class="fa fa-cog text-light" aria-hidden="true"></i></a>
                      <div class="modal fade" id="update{{ $data->id_produit }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content">
                            <div class="modal-header">
                              <h5 class="modal-title" id="myModalLabel" style="width: 100%;">{{$data->label}}</h5>
                            </div>
                            <form action="{{ '/crm/commandeedit/' .$commande->id . '/updateqte/' .$data->id_produit }}" method="POST"  style="display: inline-block;">
                              <div class="modal-body">
                                @csrf
                                <label>Quantité :</label>
                                <input type="text" class="form-control" name="qtepd" id="qtepd" value="{{$data->quantite}}" onkeypress="return onlyNumbers(event)" required>
                              </div>
                              <div class="modal-footer">
                                <button type="submit" class="btn btn-primary" style="margin-right: 15px;">Modifier</button>
                                <button type="button" class="btn btn-danger dismiss" data-dismiss="modal">Annuler</button>
                              </div>
                            </form>
                          </div>
                        </div>
                      </div> 
                      @if($productstocount > 1)
                      <a class="btn btn-danger" data-toggle="modal" data-target="#destroy{{ $data->id_produit }}"><i class="fa fa-times text-light" aria-hidden="true"></i></a>
                      <div class="modal fade" id="destroy{{ $data->id_produit }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content" style="text-align: center;">
                            <div class="modal-header">
                              <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous effectuer la suppression ?</h5>
                            </div>
                            <div class="modal-body">
                              <form action="{{ '/crm/commandeedit/' .$commande->id . '/destroy/' .$data->id_produit }}" method="POST"  style="display: inline-block;">
                                @csrf
                                <input type="text" value="{{$data->montant}}" id="montant" name="montant" hidden>
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
                  @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

    </div>

  <script>
    function onlyNumbers(e) {
      var keynum;
      var keychar;
      var numcheck;

      if(window.event) // IE
      {
        keynum = e.keyCode;
      }
      else if(e.which) // Netscape/Firefox/Opera
      {
        keynum = e.which;
      }
      keychar = String.fromCharCode(keynum);
      numcheck = /\d/;
      return numcheck.test(keychar);
    }
  </script>
@endsection