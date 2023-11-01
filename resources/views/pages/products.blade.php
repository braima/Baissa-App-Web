@extends('layouts.frontend.app')

@push('css')

@endpush

@section('content')

    

    @include('layouts.frontend.partial.header')

    @include('layouts.messagesfront')


    <div class="panierglob" id="composer-mon-panier">

        <button class="cart-active float">

            <i class="ti-shopping-cart my-float"></i>

        </button>

        <p class="search-active float-total">00.00 dhs</p>

        <p class="VerifyCart hidden">verifier et valider mon panier</p>

    </div>

    

    <!-- Products -->

    <section id="products portfolio" class="about section-padding" data-scroll-index="1">

        <div class="container">

            <div class="row">

                @foreach($bmproducts as $product)

                @if($product->status == 1)

                <div class="col-md-4 product gallery-item">

                    <div class="gallery-box">

                        <div class="product-img mb-1 img-fluid animate-box gallery-img" data-animate-effect="fadeInLeft">

                            @if(empty($product->photo))

                            <p style="font-weight: bold;color: red;">Aucune image disponible pour ce produit !</p>

                            @else

                            <p class="product-price"><span>{{$product->pu}} </span>dhs</p>

                            <img src="{{ asset('produits/images/' .$product->photo) }}" alt="product" >

                            @endif

                        </div>

                        <div class="gallery-detail text-center" data-toggle="modal" data-target="#product{{ $product->id }}"> <i class="ti-plus"></i> </div>



                        <div class="modal fade" id="product{{ $product->id }}" tabindex="-1" role="dialog" aria-labelledby="basicModal" aria-hidden="true"><<<<<

                            <div class="modal-dialog modal-lg modal-dialog-centered">

                            <div class="modal-content" style="text-align: center;">

                                <div class="modal-header">

                                    <h5 class="modal-title" id="myModalLabel" style="width: 100%;">Ajouter à votre panneau</h5>

                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">

                                        <span class="ti-close" style="color: #000;font-size: 20px;"></span>

                                    </button>

                                </div>

                                <div class="modal-body product-content">

                                    <div class="row">

                                        <div class="col-md-6 product-img img-fluid">

                                            @if(empty($product->photo))

                                            <p style="font-weight: bold;color: red;">Aucune image disponible pour ce produit !</p>

                                            @else

                                            <p class="product-price"><span>{{$product->pu}} </span>dhs</p>

                                            <img src="{{ asset('produits/images/' .$product->photo) }}" alt="product" >

                                            @endif

                                        </div>

                                        <div class="col-md-6 text-justify descriptions">

                                        <h3 class="pt-2">{{$product->label}}</h3>

                                            <p>

                                                {{$product->descriptions}}

                                            </p>

                                        </div>

                                    </div>

                                </div>

                            </div>

                            </div>

                        </div>



                        <div class="product-content">

                            <div class="row">

                                <div class="col-md-12">

                                <h3 class="pt-2 hidden">{{$product->label}}</h3>

                                    <div class="">

                                        <p class="product-id">{{$product->id}}</p>

                                        <div class="price-addtocart">

                                            <div class="input-group">

                                                <button type="button"

                                                    class="quantity-left-minus " data-type="minus" data-field="">

                                                    <p>-</p>

                                                </button>

                                                <input type="number" id="quantity" name="quantity" 

                                                    class="form-control input-number" value="0" min="0" max="100">

                                                <button type="button"

                                                    class="quantity-right-plus " data-type="plus" data-field="">

                                                    <p>+</p>

                                                </button>

                                            </div>

                                            <div class="product-price hidden">

                                                <p><span>{{$product->pu}}</span>dhs</p>

                                            </div>

                                        </div>

                                        <a class="product-addtocart add-to-cart" title="Add To Cart" href="#" >

                                            <button class="add-to-cart-notice">Ajouter au panier +</button>

                                        </a>

                                        <i class="bi bi-check2 add-to-cart-done hidden"></i>

                                        <p class='inCartAlert hidden'>Produit a été inséré dans votre panier.</p>

                                    </div>

                                </div>

                            </div>

                        </div>

                               

                    </div>

                </div>

                @endif

                @endforeach

            </div>

        </div>

    </section>



    <div class="main-cart-active">

        <div class="sidebar-search-icon">

            <button class="cart-close"><i class="ti-close"></i></button>

        </div>



        <div class="container">

            <div class="row justify-content-center">

                <div class="col-md-12 text-center p-0 mt-3 mb-2">

                    <div class="px-0 pt-4 pb-0 mt-3 mb-3">

                        <form id="form" action="submitorder" method="POST" class="needs-validation" novalidate>

                        {{ csrf_field() }}

                            <ul id="progressbar" class="pb-40">

                                <li class="active" id="step1"><strong>Validation du Produits</strong></li>

                                <li id="step2"><strong>Informations & Paiement</strong></li>

                            </ul>

                            <fieldset>

                                <!-- <h2>Welcome To GFG Step 1</h2> -->

                                <div class="row">

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">

                                        <div class="table-content table-responsive cart-table-content">

                                            <table class="mycard-table">

                                                <thead>

                                                    <tr>

                                                        <th>supprimer</th>

                                                        <th>image</th>

                                                        <th class="product-id">id</th>

                                                        <th>intitulé du produit</th>

                                                        <th>prix unitaire</th>

                                                        <th>quantité</th>

                                                        <th>sous-total</th>

                                                    </tr>

                                                </thead>

                                                <tbody class="cart-products">

                                                    

                                                </tbody>

                                            </table>

                                        </div>

                                    </div>

                                </div>

                                <button class="next-step next-step1  btn btn-secondary" name="next-step" type="button">Étape suivante</button>

                            </fieldset>

                            <fieldset>


                                <div class="row formfields">

                                    <div class="col-lg-6">

                                        <div class="billing-info mb-20">

                                            <input type="text" class="form-control" id="clientname validationCustom01" name="clientname" placeholder="Nom complet" required>

                                            <div class="invalid-feedback">Champs Obligatoire !</div>

                                        </div>

                                    </div>

                                    <div class="col-lg-6 col-md-6">

                                        <div class="billing-info mb-20">

                                            <input class="form-control" type="tel" id="clientphone validationCustom02" name="clientphone" pattern="^\d{2}\d{2}\d{2}\d{2}\d{2}$" onkeypress="return onlyNumbers(event)" placeholder="06 1234 5678" maxlength="10" required >

                                            <div class="invalid-feedback">Écrivez un numéro de téléphone valide !</div>

                                        </div>

                                    </div>

                                    <div class="col-lg-8">

                                        <div class="billing-info mb-20">

                                            <input class="form-control" id="clientadress validationCustom03" name="clientadress" placeholder="Adresse" type="text" required >

                                            <div class="invalid-feedback">Champs Obligatoire !</div>

                                        </div>

                                    </div>

                                    <div class="col-lg-4">

                                        <div class="billing-info mb-20">

                                            <input class="form-control" type="text" id="clientville validationCustom04" name="clientville" placeholder="Ville" required >

                                            <div class="invalid-feedback">Champs Obligatoire !</div>

                                        </div>

                                    </div>

                                </div>

                                <div class="row paiementsmode">

                                    <div class="col-md-6" style="background: #f3f3f3;">

                                        <div class="your-order-info-wrap">

                                            <div class="your-order-info order-total">

                                                <b>Total :</b> <input type="text" id="totat_ttc" readonly name="totat_ttc" value="0"> Dhs

                                                <input id="date_creation" name="date_creation" value="<?php echo date('Y-m-d H:i:s');?>" hidden required>

                                                <p class="livraisongratuit" style="display:none" >Livraison : Gratuit</p>

                                                <p class="livraison45" style="display:none">Livraison : 45 Dhs</p>

                                            </div>

                                        </div>

                                    </div>

                                    <div class="col-md-6" style="background: #f3f3f3;padding-top: 1em;">

                                        <div class="payment-method payment-method2">

                                            <div id="pickup-options" class="billing-select  mb-20">

                                                <label>Choisir la methode de payment:</label>

                                                <select id="payoption" name="payoption" required>

                                                    <option  value="espece" selected>en espèces</option>


                                                </select>                                                    

                                            </div>

                                        </div>

                                    </div>

                                </div>
                                <button class="btn btn-secondary lancercmd" type="submit">Lancer ma commande</button>
                                <button class="previous-step  btn btn-secondary" name="previous-step" type="button">Étape précédente</button>

                            </fieldset>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    

    @include('layouts.frontend.partial.footer')



@endsection



@push('js')
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

<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
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

