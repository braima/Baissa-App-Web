@extends('layouts.appPassword')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-3"></div>
        <div class="col-md-6">
            <div class="card restor">
                <div class="card-header">{{ __('Envoyer le lien de réinitialisation du mot de passe') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <form method="POST" action="{{ route('password.email') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('Addresse E-Mail') }}</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    {{ __('Réinitialisation') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <a class="nav-link" href="{{ url('/') }}"><i class="fas fa-long-arrow-alt-left"></i> Retour vers Paris Magic Trip</a> <br>
            <a class="nav-link" href="{{ route('login') }}"><i class="fas fa-long-arrow-alt-left"></i> Retour vers Login</a>
        </div>
        <div class="col-md-3"></div>
    </div>
</div>
@endsection
