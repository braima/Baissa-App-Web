<?php $page = 'categories'; ?> 
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
                    <div>Categories</div>
                </div>
                <div class="page-title-heading addCat">
                    <div class="page-title-icon">
                      <a data-toggle="modal" data-target="#insertcat">
                        <i class="pe-7s-plus icon-gradient bg-mean-fruit">
                        </i>
                      </a>
                      <div class="modal fade" id="insertcat" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content" style="text-align: center;">
                            <div class="modal-header">
                              <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Insérer une Catégorie</h5>
                            </div>
                            <div class="modal-body">
                              <form action="{{'/crm/insertcategory'}}" method="get"  style="display: inline-block;width: 100%;text-align: left;">
                                {{ csrf_field() }}

                                <label for="">Designation</label>
                                  <input class="form-control" type="text" name="label" required>

                                <label for="">Ordre</label>
                                  <input class="form-control" type="number" name="order" required>

                                <label for="">Status</label>
                                  <select class="form-control" name="status" id="status" required>
                                    <option value="0" selected>Désactiver</option>
                                    <option value="1">Activer</option>
                                  </select>

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
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-body">

                  <table style="width: 100%;" id="example" class="table table-hover table-striped table-bordered">
                      <thead>
                        <tr>
                          <th>#.</th>
                          <th>Designation</th>
                          <th>Ordre</th>
                          <th style="text-align: center;">Status</th>
                          <th style="text-align: center;">Action</th>
                        </tr>
                      </thead>
                      <tbody>
                        @foreach ($categories as $categorie)
                        <tr>
                          <td> {{ $categorie->id}}</td>
                          <td> {{ $categorie->label  }}</td>
                          <td> {{ $categorie->ordre}}</td>
                          <td style="text-align: center;"> 
                          @if($categorie->status == 0)
                            <a class="btn btn-danger" data-toggle="modal" data-target="#status{{ $categorie->id }}" style="color: #fff;"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>
                            <div class="modal fade" id="status{{ $categorie->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="text-align: center;">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous changer le status ?</h5>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{'/crm/categorystatus/' . $categorie->id}}" method="get"  style="display: inline-block;">
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
                            <a class="btn btn-success" data-toggle="modal" data-target="#status{{ $categorie->id }}" style="color: #fff;"><i class="fa fa-toggle-on" aria-hidden="true"></i></a>
                            <div class="modal fade" id="status{{ $categorie->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="text-align: center;">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous changer le status ?</h5>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{'/crm/categorystatus/' . $categorie->id}}" method="get"  style="display: inline-block;">
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
                          <td style="text-align: center;">
                            <a class="btn btn-primary" data-toggle="modal" data-target="#update{{ $categorie->id }}" style="color: #fff;"><i class="fa fa-cog" aria-hidden="true"></i></a>
                            <div class="modal fade" id="update{{ $categorie->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="text-align: center;">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous modifier la Catégorie?</h5>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{'/crm/updatecategory/' . $categorie->id}}" method="get"  style="display: inline-block;width: 100%;text-align: left;">
                                      {{ csrf_field() }}

                                      <label for="">Designation</label>
                                      <input class="form-control" type="text" name="label" value="{{$categorie->label}}" required>

                                      <label for="">Ordre</label>
                                        <input class="form-control" type="number" name="order" value="{{$categorie->ordre}}"  required style="margin-bottom: 20px;">

                                        <input class="form-control" type="text" name="status" value="{{$categorie->status}}"  required hidden>

                                      <button type="submit" class="btn btn-success">Modifier</button>
                                      <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                                    </form>
                                  </div>
                                </div>
                              </div>
                            </div> 

                            <a class="btn btn-danger" data-toggle="modal" data-target="#destroy{{ $categorie->id }}" style="color: #fff;"><i class="fa fa-times" aria-hidden="true"></i></a>
                            <div class="modal fade" id="destroy{{ $categorie->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                              <div class="modal-dialog modal-lg modal-dialog-centered">
                                <div class="modal-content" style="text-align: center;">
                                  <div class="modal-header">
                                    <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous supprimer la catégorie?</h5>
                                  </div>
                                  <div class="modal-body">
                                    <form action="{{'/crm/destroycategory/' . $categorie->id}}" method="get"  style="display: inline-block;">
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
                          <th>Ordre</th>
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