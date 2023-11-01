<?php $page = 'produits'; ?> 
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
    .desactiver {
      color: red;
      margin-right: 10px;
    }
    .activer {
      color: #04cc78;
      margin-right: 10px;
    }
  </style>
  <style>
    .uploadimage {
      margin: 2em auto 20px auto;
      text-align: center;
    }
    .uploadimage .pe-7s-cloud-upload {
      font-size: 2em;
      color: #778e86;
      display: block;
    }
    input#file {
      border: 1px solid #c3c3c3;
      padding: 0;
      height: auto;
      width: 50%;
      margin: 0 auto;
    }
</style>
@endsection

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
                    <div>Produits</div>
                </div>
                <div class="page-title-heading addCat">
                    <div class="page-title-icon">
                      <a data-toggle="modal" data-target="#insertproduct">
                        <i class="pe-7s-plus icon-gradient bg-mean-fruit">
                        </i>
                      </a>
                      <div class="modal fade" id="insertproduct" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content" style="text-align: center;">
                            <div class="modal-header">
                              <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Insérer un Produit</h5>
                            </div>
                            <div class="modal-body">
                              <form action="{{'/crm/insertproduct'}}" method="post" enctype="multipart/form-data" style="display: inline-block;width: 100%;text-align: left;">
                                {{ csrf_field() }}

                                <div class="row">
                                  <div class="col-md-8">
                                    <label for="">Designation</label>
                                    <input class="form-control" type="text" name="label" required>
                                  </div>
                                    
                                  <div class="col-md-4">
                                    <label for="">Prix Unitaire</label>
                                    <input class="form-control" type="number" name="pu" required>
                                  </div>
                                </div>
                                  
                                <div class="row">
                                  <div class="col-md-4">
                                    <label for="">Catégorie</label>
                                    <select class="form-control" name="id_category" required>
                                    @foreach($categories as $categorie)
                                      <option value="{{$categorie->id}}">{{$categorie->label}}</option>
                                    @endforeach
                                    </select>
                                  </div>
                                    
                                  <div class="col-md-4">
                                    <label for="">Stock</label>
                                    <input class="form-control" type="number" name="stock" required>
                                  </div>

                                  <div class="col-md-4">
                                    <label for="">Ordre</label>
                                    <input class="form-control" type="number" name="ordre" required>
                                  </div>
                                </div>

                                <div class="row">
                                  <div class="col-md-12">
                                    <label>Description :</label> 
                                    <textarea class="form-control" name="descriptions" id="descriptions" cols="2" rows="4" required></textarea>
                                  </div>
                                </div>  

                                <div class="row">
                                  <div class="col-md-12">
                                    <div class="uploadimage">
                                        <i class="pe-7s-cloud-upload"> </i>
                                        <label>Selectionner image à uploader:</label> 
                                        <input type="file" class="form-control" name="file" id="file" required>
                                    </div>
                                  </div>
                                </div>  

                                <button type="submit" class="btn btn-success">Ajouter</button>
                                <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>   
                    </div>
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
                          <th>Photo</th>
                          <th>Designation</th>
                          <th>P.Unitaire</th>
                          <th>Catégorie</th>
                          <th>Stock</th>
                          <th>Ordre</th>
                          <th>Barcode</th>
                          <th>Status</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($produits as $produit)
                        <tr>
                          <td> {{ $produit->id}}</td>
                          <td> <img class="d-block" src="{{ asset('produits/images/' .$produit->photo) }}" alt="baissa produits" width="50px"></td>
                          <td> {{ $produit->label }}</td>
                          <td> {{ $produit->pu }}</td>
                          <td> 
                            @foreach ($categories as $categorie)
                              @if($categorie->id == $produit->id_category)
                              {{$categorie->label}}
                              @endif
                            @endforeach
                          </td>
                          <td> {{ $produit->stock }}</td>
                          <td> {{ $produit->ordre }}</td>
                          <td>
                            @php
                              echo '<img src="data:image/png;base64,' . DNS1D::getBarcodePNG($produit->barcode, 'C128',1.4,22) . '" alt="barcode"   />';
                            @endphp
                            <br>
                            {{ $produit->barcode }}
                          </td>
                          <td> 
                            @if($produit->status == 0)
                              <a class="btn btn-danger" data-toggle="modal" data-target="#status{{ $produit->id }}" style="color: #fff;"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>
                              <div class="modal fade" id="status{{ $produit->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                  <div class="modal-content" style="text-align: center;">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous changer le status ?</h5>
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{'/crm/produitstatus/' . $produit->id}}" method="get"  style="display: inline-block;">
                                        {{ csrf_field() }}
                                        <input type="text" name="statustochange" value="1" hidden>
                                        <button type="submit" class="btn btn-success">Activer</button>
                                        <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @else
                              <a class="btn btn-success" data-toggle="modal" data-target="#status{{ $produit->id }}" style="color: #fff;"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>
                              <div class="modal fade" id="status{{ $produit->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                                <div class="modal-dialog modal-lg modal-dialog-centered">
                                  <div class="modal-content" style="text-align: center;">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous changer le status ?</h5>
                                    </div>
                                    <div class="modal-body">
                                      <form action="{{'/crm/produitstatus/' . $produit->id}}" method="get"  style="display: inline-block;">
                                        {{ csrf_field() }}
                                        <input type="text"  name="statustochange" value="0" hidden>
                                        <button type="submit" class="btn btn-success">Désactiver</button>
                                        <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            @endif
                          </td>
                          <td>
                            <a class="btn btn-info" data-toggle="modal" data-target="#update{{ $produit->id }}" style="color: #fff;"><i class="fa fa-cog" aria-hidden="true"></i></a>
                            <div class="modal fade" id="update{{ $produit->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="text-align: center;">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous modifier le produit?</h5>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{'/crm/updateproduit/' . $produit->id}}" method="get"  style="display: inline-block;width: 100%;text-align: left;">
                                      {{ csrf_field() }}

                                      <label for="">Designation</label>
                                        <input class="form-control" type="text" name="label" value="{{$produit->label}}" required>

                                      <label for="">Prix Unitaire</label>
                                        <input class="form-control" type="number" name="pu" value="{{$produit->pu}}" required>

                                      <label for="">Catégorie</label>
                                        <select class="form-control" name="id_category" required>
                                          
                                          @foreach($categories as $categorie)
                                            @if($categorie->id == $produit->id_category)
                                              <option value="{{$categorie->id}}" selected>{{$categorie->label}}</option>
                                              @else
                                              <option value="{{$categorie->id}}">{{$categorie->label}}</option>
                                            @endif
                                          @endforeach
                                        </select>

                                      <label for="">Stock</label>
                                        <input class="form-control" type="number" name="stock" value="{{$produit->stock}}" required>

                                      <label for="">Ordre</label>
                                        <input class="form-control" type="number" name="ordre" value="{{$produit->ordre}}" required>

                                        <label>Description</label> 
                                        <textarea class="form-control" name="descriptions" id="descriptions" cols="2" rows="4" required>{{$produit->descriptions}}</textarea> 

                                      <div style="margin-top:20px;"></div>
                                      <button type="submit" class="btn btn-success">Modifier</button>
                                      <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <a class="btn btn-primary" data-toggle="modal" data-target="#updateimg{{ $produit->id }}" style="color: #fff;"><i class="fa fa-fw" aria-hidden="true"></i></a>
                            <div class="modal fade" id="updateimg{{ $produit->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="text-align: center;">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous modifier la photo de produit?</h5>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{'/crm/updateimgproduct/' . $produit->id}}" method="post" enctype="multipart/form-data" style="display: inline-block;width: 100%;">
                                      {{ csrf_field() }}

                                      <div class="row">
                                        <div class="col-md-6">
                                          <img src="{{ asset('produits/images/' .$produit->photo) }}" alt="baissa produits" width="100%">
                                        </div>
                                        <div class="col-md-6">
                                          <div class="uploadimage" style="margin-top: 30%;}">
                                            <i class="pe-7s-cloud-upload"> </i>
                                            <label>Selectionner image à uploader:</label> 
                                            <input type="file" class="form-control" name="file" id="file" required style="width: 100%;">
                                          </div>

                                          <div style="margin-top:20px;"></div>
                                          <button type="submit" class="btn btn-success">Modifier</button>
                                          <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                                        </div>
                                      </div>

                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <a class="btn btn-danger" data-toggle="modal" data-target="#destroy{{ $produit->id }}" style="color: #fff;"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <div class="modal fade" id="destroy{{ $produit->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="text-align: center;">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous supprimer le produit?</h5>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{'/crm/destroyproduit/' . $produit->id}}" method="get"  style="display: inline-block;">
                                      {{ csrf_field() }}
                                      <button type="submit" class="btn btn-success">Supprimer</button>
                                      <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div>  
                          </td>
                        </tr>
                        @endforeach
                      </tbody>
                      <tfoot>
                        <tr>
                          <th>#.</th>
                          <th>Designation</th>
                          <th>P.Unitaire</th>
                          <th>Catégorie</th>
                          <th>Stock</th>
                          <th>Photo</th>
                          <th>Ordre</th>
                          <th>Barcode</th>
                          <th>Status</th>
                          <th>Action</th>
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