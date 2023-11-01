@extends('layouts.frontend.app')

@push('css')
@endpush

@section('content')

    @include('layouts.frontend.partial.header')
    
    <!--  Deal Product Start Here -->
    <div class="rdv">
        <div class="container">
            <div class="row align-items-center">
                <div class="offset-lg-6 col-lg-6">
                    <div class="main-deal-pro">
                        <div class="section-title deal-header">
                            <h2>Enregistrer votre Rendez-vous</h2>
                            <p>& vous verrez surprendre avec le résultat</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  Deal Product End Here -->
    <!-- Regester Page Start Here -->
    <div class="rdv register-area white-bg ptb-90">
        <div class="container">
            @include('layouts.messages')
            <div class="row">
                <div class="col-xl-12">
                    <div class="register-contact  clearfix">
                        <form id="contact-form" class="contact-form" action="saverdv" method="post">
                            @csrf
                            <div class="address-wrapper row">
                                <div class="col-md-12">
                                    <div class="address-fname">
                                        <input class="form-control" type="text" name="name" placeholder="Nom Complet" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="address-email">
                                        <label for=""></label>
                                        <input class="form-control" type="email" name="email" placeholder="Adresse Email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="address-phone">
                                        <input class="form-control" type="phone" name="phone" placeholder="06 00 00 00 00" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="address-datetime">
                                        <input class="form-control" type="datetime-local" name="datetime" placeholder="Date & Heur" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="address-subject">
                                        <input class="form-control" type="text" name="objet" placeholder="Objet de Rendez-vous" required>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="address-textarea">
                                        <label for="">Rédigez votre demande</label>
                                        <textarea name="message" class="form-control" placeholder="Rédigez..." required></textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-content mail-content clearfix">
                                <div class="send-email float-md-right">
                                    <input type="submit" value="Enregistrer" class="return-customer-btn" >
                                </div>
                            </div>
                            <p class="form-message"></p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
    @include('layouts.frontend.partial.footer')

@endsection

@push('js')
	
@endpush