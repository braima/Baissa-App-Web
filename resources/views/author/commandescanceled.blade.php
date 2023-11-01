<?php $page = 'commandescanceled'; ?> 
@extends('layouts.appAuthor')
    
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
                    <div>Commandes Annulées</div>
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
                          <th style="width: 120px;">Client</th>
                          <th>Téléphone</th>
                          <th>Adresse</th>
                          <th>Montant Dhs</th>
                          <th>Paiement</th>
                          <th>Date</th>
                          <th style="width: 200px;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($commandes as $commande)
                        @if($commande->status == 2)
                        <tr>
                          <td> {{ $commande->id}}</td>
                          <td> {{ $commande->client_nom }}</td>
                          <td> {{ $commande->client_tel }}</td>
                          <td> {{ $commande->client_adresse }}</td>
                          <td> {{ $commande->total_ttc }}</td>
                          <td> {{ $commande->type_livraison}}</td>
                          <td> {{ date('d-m-Y', strtotime($commande->created_at))}}</td>
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