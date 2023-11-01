<?php $page = 'utilisateurs'; ?> 
@extends('layouts.appadmin')
@push('css')
  <style>
    .btn.btn-icon.btn-sm{
      margin: 0;
    }
    .modal-dialog{
      box-shadow: none;
    }
    .modal-backdrop.show, .show.blockOverlay{
      display: none;
    }
  </style>
@endpush
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
                    <div>Utilisateurs</div>
                </div>
            </div>
        </div>

        <div class="row">
          <div class="col-md-4">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">Utilisateurs Actifs</h4>
              </div>
              <div class="card-body">
                <ul class="list-unstyled team-members">
                  @foreach($users as $user)
                    <li>
                    <div class="row">
                      <div class="col-md-2 col-2">
                        <div class="avatar">
                          <img src="{{ asset('images/avatars/face.png') }}" alt="Circle Image" class="img-circle img-no-padding img-responsive" style="width: 35px;">
                        </div>
                      </div>
                      <div class="col-md-6 col-6" style="padding-top: 5px;">
                        {{$user->name}}
                        <br />
                        <span class="text-muted">
                        </span>
                      </div>
                      <div class="col-md-4 col-4 text-right">
                        <button class="btn btn-sm btn-outline-success btn-round btn-icon" data-toggle="modal" data-target="#update{{ $user->id }}"><i class="pe-7s-lock" aria-hidden="true"></i></button>
                        <button class="btn btn-sm btn-outline-danger btn-round btn-icon" data-toggle="modal" data-target="#destroy{{ $user->id }}"><i class="fa fa-trash" aria-hidden="true"></i></button>
                      </div>

                      <div class="modal fade" id="destroy{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content" style="text-align: center;">
                            <div class="modal-header">
                              <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Voulez-vous supprimé l'utilisateur?</h5>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('admin.destroyuser', ['id' => $user->id]) }}" method="POST"  style="display: inline-block;">
                                {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                                <button type="submit" class="btn btn-danger">Supprimer</button>
                                <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>

                      <div class="modal fade" id="update{{ $user->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered">
                          <div class="modal-content" >
                            <div class="modal-header">
                              <h5 class="modal-title" id="myModalLabel" style="width: 100%;">User : {{$user->name}}</h5>
                            </div>
                            <div class="modal-body">
                              <form action="{{ route('admin.updateuser', ['id' => $user->id]) }}" method="POST"  style="display: inline-block;width:100%;">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}
                                <label>Full Name :</label>
                                <input type="text" name="nom" id="nom" class="form-control" value="{{$user->name}}" style="margin-bottom:15px;" required>
                                <label>E-Mail :</label>
                                <input type="text" name="email" id="email" class="form-control" value="{{$user->email}}" style="margin-bottom:15px;" required>
                                <label>Password :</label>
                                <input type="text" name="password" id="password" class="form-control" placeholder="____________" style="margin-bottom:15px;" required>
                                <button type="submit" class="btn btn-primary">Modifier</button>
                                <button type="button" class="btn btn-warning dismiss" data-dismiss="modal">Annuler</button>
                              </form>
                            </div>
                          </div>
                        </div>
                      </div>
                      <div class="shadowmodal"></div>

                    </div>
                  </li>
                  @endforeach
                </ul>
              </div>
            </div>
          </div>
          <div class="col-md-8">
           @include('layouts.messages')
            <div class="card card-user">
              <div class="card-header">
                <h5 class="card-title">Ajouter nouveau utilisateur</h5>
              </div>
              <div class="card-body">
                <form action="{{ url('/utilisateurs/createuser') }}" method="GET">
                  <div class="row">
                    <div class="col-md-5 pr-1">
                      <div class="form-group">
                        <label>Role *</label>
                        <select name="roleuser" id="roleuser" class="form-control">
                          <option value="1">Adminstrateur</option>
                          <option value="2">Editeur Web</option>
                          <option value="1" class="editorcenter">Editeur Centre</option>
                        </select>
                        <input type="text" class="subuser_id" value="0" name="subuser_id" hidden>
                      </div>
                    </div>
                    <div class="col-md-3 px-1">
                      <div class="form-group">
                        <label>Nom Complet *</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="Nom" required>
                      </div>
                    </div>
                    <div class="col-md-4 pl-1">
                      <div class="form-group">
                        <label for="exampleInputEmail1">E-mail *</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="E-mail" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Emplacement *</label>
                        <select name="emplacement" id="emplacement" class="form-control" required>
                            <option value="agadir">Agadir</option>
                            <option value="marrakech">Marrakech</option>
                            <option value="casablanca">Casa Blanca</option>
                        </select>
                        <input type="text" class="subuser_id" value="0" name="subuser_id" hidden>
                      </div>
                    </div>
                    <div class="col-md-6 pr-1">
                      <div class="form-group">
                        <label>Mot de Passe *</label>
                        <input type="text" name="password" id="password" class="form-control" placeholder="Mot de passe" required>
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="update ml-auto mr-auto">
                      <button type="submit" class="btn btn-primary btn-round">Ajouter</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>

    <script type="text/javascript">
        $(document).ready(function(){
            $(document).on('change','#roleuser',function(){
                
                $('#roleuser option').each(function() {
                    if($('.editorcenter').is(':selected')){
                        $('.subuser_id').val('4');
                    }
                });
            });
        });
    </script>

@endsection


