
$(document).ready(function () {

    $('.owl-carousel').owlCarousel({
        loop:true,
        margin:15,
        nav:true,
        dots:false,
        autoWidth:true,
        navText: [
            '<i class="fa fa-caret-left" aria-hidden="true"></i>',
            '<i class="fa fa-caret-right" aria-hidden="true"></i>'
        ],
        responsive:{
            0:{
                items:2
            },
            600:{
                items:4
            },
            1000:{
                items:6
            }
        }
    });

    // $('.panierglob').click(function(){
    //     $(".modal-backdrop").hide(); 
    //     $(".about").hide("slow"); 
    // });
    $('.cart-close').click(function(){
        $(".modal-backdrop").show(); 
        $(".about").show(); 
    });
    
    $('.alert .btn-close').click(function(){
        $(".alertproducts").hide(); 
    });

    $(".next-step1").click(function(){
        var rowCount = $('.mycard-table>tbody>tr').length;
        if(rowCount<=4){
            $('.livraison45').css("display","block");
            $('.livraisongratuit').css("display","none");
        }else{
            $('.livraison45').css("display","none");
            $('.livraisongratuit').css("display","block"); 
        }
    });

    $('.quantity-right-plus').click(function(e){
        
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var $this = $(this);
        var $input = $this.closest('div').find('input');
        var value = parseInt($input.val());
        value = value + 1;
        $input.val(value);
        // If is not undefined
    });

    $('.quantity-left-minus').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var $this = $(this);
        var $input = $this.closest('div').find('input');
        var value = parseInt($input.val());
        // If is not undefined
    
        // Increment
        if (value >= 1) {
            value = value - 1;
        } else {
            value = 0;
        }

        $input.val(value);
    });

    
    $('.formfields input').keyup(function() {

        var empty = false;
        $('.formfields input').each(function() {
            if ($(this).val() == '') {
                empty = true;
            }
        });

        if (empty) {
            $('.lancercmd').attr('disabled', 'disabled'); 
        } else {
            $('.lancercmd').removeAttr('disabled');
        }
    });
    

    var currentGfgStep, nextGfgStep, previousGfgStep;
    var opacity;
    var current = 1;
    var steps = $("fieldset").length;

    setProgressBar(current);

    $(".next-step").click(function () {

        currentGfgStep = $(this).parent();
        nextGfgStep = $(this).parent().next();

        $("#progressbar li").eq($("fieldset")
            .index(nextGfgStep)).addClass("active");

        nextGfgStep.show();
        currentGfgStep.animate({ opacity: 0 }, {
            step: function (now) {
                opacity = 1 - now;

                currentGfgStep.css({
                    'display': 'none',
                    'position': 'relative'
                });
                nextGfgStep.css({ 'opacity': opacity });
            },
            duration: 500
        });
        setProgressBar(++current);
    });

    $(".previous-step").click(function () {

        currentGfgStep = $(this).parent();
        previousGfgStep = $(this).parent().prev();

        $("#progressbar li").eq($("fieldset")
            .index(currentGfgStep)).removeClass("active");

        previousGfgStep.show();

        currentGfgStep.animate({ opacity: 0 }, {
            step: function (now) {
                opacity = 1 - now;

                currentGfgStep.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previousGfgStep.css({ 'opacity': opacity });
            },
            duration: 500
        });
        setProgressBar(--current);
    });

    function setProgressBar(currentStep) {
        var percent = parseFloat(100 / steps) * current;
        percent = percent.toFixed();
        $(".progress-bar")
            .css("width", percent + "%")
    }

    $(".submit").click(function () {
        return false;
    })


    // ADT Notice 

    $('.quantity-right-plus').click(function (e) {

        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var $this = $(this);
        // $this.closest('.product-content').find('.add-to-cart-notice').removeClass("hidden");
        // $this.closest('.product-content').find('.add-to-cart').css({"display": "block"});
        $this.closest('.product-content').find('.add-to-cart-notice').css({"animation" : "blinkingText 1.2s infinite"});

    });

    // Product Quantity Update Notice 

    $('input.input-number').on('change', function(e){
        var $this = $(this);
        var value = parseInt($this.val());
        if (value > 0) {
            $this.closest('.product-content').find('.add-to-cart-notice').css({"animation" : "blinkingText 1.2s infinite"});
            // $this.closest('.product-content').find('.add-to-cart').css({"display": "block"});    
        }else{
            $this.closest('.product-content').find('.add-to-cart-notice').css({"animation" : "none"});
            // $this.closest('.product-content').find('.add-to-cart').css({"display": "none"});  
        }
    });

    
    $('.quantity-left-minus').click(function (e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        var $this = $(this);
        var $input = $this.closest('div').find('input');
        var value = parseInt($input.val());
        if (value > 1) {
            // $this.closest('.product-content').find('.add-to-cart-notice').removeClass("hidden");
            // $this.closest('.product-content').find('.add-to-cart').css({"display": "block"});     
        }else{
            // $this.closest('.product-content').find('.add-to-cart-notice').addClass("hidden");
            // $this.closest('.product-content').find('.add-to-cart').css({"display": "none"});  
            $this.closest('.product-content').find('.add-to-cart-notice').css({"animation" : "none"});
        }

    });



    //Product ATC Button Function 

    $('.product-addtocart').click(function (e) {
        e.preventDefault();
        var $thisProduct = $(this);
        // $thisProduct.css({"display": "none"});
        var $content = $thisProduct.closest('.product-content');
        var $ProductId = $content.find("p.product-id").html();
        var $ProductName = $content.find("h3").html();
        var ProductQuantity = $content.find(".input-number").val();
        var $ProductPrice = $content.find("span").html();
        var $ProductImage = $content.parent().find(".product-img img").attr("src");
        var TotalProducts = parseFloat(ProductQuantity)*parseFloat($ProductPrice);

        var $Cart = $(".cart-products");
        console.log($ProductId);
        if (ProductQuantity!=0){
            
            // if(ProductQuantity==3 && $ProductName=="Blush"){
            //     TotalProducts = 150;
            // }
            $thisProduct.closest('.product-content').find('.add-to-cart-notice').addClass("hidden");
            $thisProduct.closest('.product-content').find('.add-to-cart').css({"transform": "scale(1)", "padding":"4px", "font-size" : "2rem","color": "#8f2138" ,"background-color" :"#fff", "border": "1px solid #8f2138"});                                    
            $Cart.prepend('<tr><td class="product-remove">'
                +'<a class="product-delete" href="#"><i class="ti-close product-delete-icon"></i></a>'
                +'</td><td class="product-thumbnail"><a href="#"><img src="'+$ProductImage+'" alt=""></a></td><td class="product-id">'
                +'<input type="text" id="idproduct[]" name="idproduct[]" value="'+$ProductId+'" readonly hidden>'
                +'<input type="text" id="time[]" name="time[]" value="13:00" readonly>'
                +'</td>'
                +'<td class="product-name"><input type="text" id="nomarticle[]" name="nomarticle[]" readonly value="'
                +$ProductName+'" ></td><td class="product-price-cart"><span class="amount">'
                +'<input type="text" id="prix[]" name="prix[]" readonly value="'
                +$ProductPrice+'"></span></td><td class="product-quantity">'
                +'<div class="cart-plus-minus">'
                +'<input class="cart-plus-minus-box quantity" type="text" id="quantity[]" name="quantity[]" value="'
                +ProductQuantity+'"></div></td><td class="product-subtotal">'
                +'<input class="product-subtotal-cart" type="text" id="soustotal[]" name="soustotal[]" readonly value="'
                +TotalProducts +'"></td></tr>');
        $thisProduct.addClass('hidden') ;
        $content.parent().find(".add-to-cart-done").removeClass('hidden');       
        $content.parent().find(".inCartAlert").removeClass('hidden'); 
        $content.parent().find('.input-group').addClass('hidden');
        $(".VerifyCart").removeClass('hidden');

        var sum=0;
        $('.product-subtotal-cart').each(function(){
            sum += parseFloat(this.value);
             });
        $(".float-total").html(sum+' dhs');
        $("#totat_ttc").val(sum);
        console.log($(".float-total").text());
        console.log(sum);
        if (sum >= 200){
            $('.free-shipping-notice').removeClass('hidden');
            $('.paid-shipping-notice').addClass('hidden');
        } else if (sum==0){
            $('.free-shipping-notice').addClass('hidden');
            $('.paid-shipping-notice').addClass('hidden');
        } else{
            $('.free-shipping-notice').addClass('hidden');
            $('.paid-shipping-notice').removeClass('hidden');
        }


        var cart = $('.cart-active');
        var imgtodrag = $('.product-img').find("img").eq(0);
        
        if (imgtodrag) {
            var imgclone = imgtodrag.clone()
                .offset({
                top: imgtodrag.offset().top,
                left: imgtodrag.offset().left
            })
            
                .css({
                'opacity': '0.8',
                    'position': 'absolute',
                    'height': '100px',
                    'width': '100px',
                    'z-index': '100'
            }, )
                .appendTo($('body'))
                .animate({
                'top': cart.offset().top + 10,
                    'left': cart.offset().left + 10,
                    'width': 45,
                    'height': 45
            }, 500 ); 
          

            imgclone.animate({
                'width': 0,
                    'height': 0
            }, function () {
                $(this).detach()
            });
            setTimeout(function () {
                cart.addClass('float-total-shake');
            }, 500)
            setTimeout(function () {
                cart.removeClass('float-total-shake');
            }, 500)
            
        }
        } else{
            return null;
        }         
    });

    ////////////////////////////////////////////

    //Product Delete Button Function

    $(document).on("click",".product-delete",function(e){
        e.preventDefault();
        var $ProductId = $(this).parent().parent().find(".product-id input:first-child").val();
        var $thisProduct = $(".product-"+$ProductId);
        $(this).parent().parent().remove();
        $thisProduct.find(".add-to-cart-done").addClass('hidden');       
        $thisProduct.find(".inCartAlert").addClass('hidden'); 
        $thisProduct.find('.input-group').removeClass('hidden');
        $thisProduct.find('.input-group').value=0;
        $thisProduct.find(".add-to-cart").removeClass('hidden');
        console.log($ProductId)
        console.log(this);
        var sum=0;
        $('.product-subtotal-cart').each(function(){
            sum += parseFloat(this.value);
             });
        $(".float-total").html(sum+' dhs');
        $("#totat_ttc").val(sum);
        console.log($(".float-total").text());
        console.log(sum);
        if (sum >= 200){
            $('.free-shipping-notice').removeClass('hidden');
            $('.paid-shipping-notice').addClass('hidden');
        } else if (sum==0){
            $('.free-shipping-notice').addClass('hidden');
            $('.paid-shipping-notice').addClass('hidden');
            $(".VerifyCart").addClass('hidden');
            // $("next-step2").addClass('hidden');
        } else{
            $('.free-shipping-notice').addClass('hidden');
            $('.paid-shipping-notice').removeClass('hidden');
        }
        
    });


    ////////////////////////////////////////////
    // Cart - Quantity Input Update
    $(document).on('change', '.cart-plus-minus-box', function(){
        var QuantityField = $(this);
        var ProductPrice = QuantityField.parent().parent().parent().find('.product-price-cart span input').val();
        var ProductQuantity = QuantityField.val();
        QuantityField.parent().parent().parent().find('.product-subtotal-cart').val(ProductQuantity*ProductPrice);
        var sum=0;
        $('.product-subtotal-cart').each(function(){
            sum += parseFloat(this.value);
             });
        $(".float-total").html(sum+' dhs');
        $("#totat_ttc").val(sum);
        if (sum >= 200){
            $('.free-shipping-notice').removeClass('hidden');
            $('.paid-shipping-notice').addClass('hidden');
        } else if (sum==0){
            $('.free-shipping-notice').addClass('hidden');
            $('.paid-shipping-notice').addClass('hidden');
        } else{
            $('.free-shipping-notice').addClass('hidden');
            $('.paid-shipping-notice').removeClass('hidden');
        }

    });
    $(document).on('change', '#totat_ttc', function(){
        console.log($(this).val());
        if (sum >= 200){
            $('.free-shipping-notice').removeClass('hidden');
            $('.paid-shipping-notice').addClass('hidden');
        } else if (sum==0){
            $('.free-shipping-notice').addClass('hidden');
            $('.paid-shipping-notice').addClass('hidden');
        } else{
            $('.free-shipping-notice').addClass('hidden');
            $('.paid-shipping-notice').removeClass('hidden');
        }
    });

});

(function ($) {
    

    //Telephone from Client Validation 212
    // $("#clientphone").keydown(function(e) {
    //     var oldvalue=$(this).val();
    //     var field=this;
    //     setTimeout(function () {
    //         if(field.value.indexOf('212') !== 0) {
    //             $(field).val(oldvalue);
    //         } 
    //     }, 1);
    // });


    ////////////////////////////////////////////


    "use strict";

    
    
    /*====== SideBar Cart active ======*/
    function sidebarCart() {
        var cartTrigger = $('button.cart-active'),
            endTriggersearch = $('button.cart-close'),
            container = $('.main-cart-active');
        cartTrigger.on('click', function() {
            container.addClass('inside');
        });
        endTriggersearch.on('click', function() {
            container.removeClass('inside');
        });
    };
    sidebarCart();
    
    // function CheckTables() {
    //     // Ignores whitespace
    //     if (($.trim($(".mycard-table tbody").html()) == "")){
    //         $(".next-step1").hide();
    //     }else{
    //         $(".next-step1").show();
    //     }
    // };
    // CheckTables();

    $(document).on("click",".float",function(e){
        e.preventDefault();
        if (($.trim($(".mycard-table tbody").html()) == "")){
            $(".next-step1").hide();
        }else{
            $(".next-step1").show();
        }
    }); 

    
    

    /*====== PickUp Slide active 
    function sidebarPickup() {
        var PUTrigger = $('button.pickup-popup'),
            endTriggersearch = $('button.pickup-popup-close'),
            container = $('.main-pickup-active');
        PUTrigger.on('click', function(e) {
            container.addClass('inside');
            PUTrigger.addClass('hidden');
            endTriggersearch.removeClass('hidden');
        });
        endTriggersearch.on('click', function(e) {
            container.removeClass('inside');
            PUTrigger.removeClass('hidden');
            endTriggersearch.addClass('hidden');
        });
    };
    sidebarPickup();======*/

    /*====== Delivery Slide active
    function sidebarDelivery() {
        var DLTrigger = $('button.delivery-popup'),
            endTriggersearch = $('button.delivery-popup-close'),
            container = $('.main-delivery-active');
        DLTrigger.on('click', function(e) {
            container.addClass('inside');
            DLTrigger.addClass('hidden');
            endTriggersearch.removeClass('hidden');
            $('.delivery-popup-img').removeClass("hidden")
        });
        endTriggersearch.on('click', function(e) {
            container.removeClass('inside');
            DLTrigger.removeClass('hidden');
            endTriggersearch.addClass('hidden');
            $('.delivery-popup-img').addClass("hidden")

        });
    };
    sidebarDelivery(); ======*/

    /*====== Search Section active ======*/
    function SearchSectionActive() {
        var searchTrigger = $('i.my-float-search'),
            Searchcontainer = $('.my-float-search-input');
            searchTrigger.on('click', function() {
                Searchcontainer.toggleClass("hidden");
        });
    };
    SearchSectionActive();

    
    $('[data-search]').on('keyup', function() {
        var searchVal = $(this).val();
        console.log(searchVal);
        var filterItems = $('[data-filter-item]');

        if ( searchVal != '' ) {
            filterItems.addClass('hidden');
            console.log($('[data-filter-item][data-filter-name*="' + searchVal.toLowerCase() + '"]').value);
		$('[data-filter-item][data-filter-name*="' + searchVal.toLowerCase() + '"]').removeClass('hidden');
        } else {
            filterItems.removeClass('hidden');
        }
    });

    
        /*--- Filter Product by Categories active ---*/
        
        $(document).ready(function() {
            $('.pagination-style-items li a').click(function() {
                $('html, body').animate({
                    scrollTop: $("#shop-1").offset().top - 200
                }, 800);
              // fetch the class of the clicked item
              var ourClass = $(this).attr('class');

              if (ourClass == 'next'){
                return null;    
              } else if (ourClass == 'prev') {  
                return null;
            } else {
                // reset the active class on all the buttons
                $('.pagination-style-items li a').removeClass('active');
                // update the active state on our clicked button
                $(this).addClass('active');
            
                if(ourClass == 'category-selector-all') {
                    // show all our items
                    $('.full-products').children('div').show();
                    $([document.documentElement, document.body]).animate({
                        scrollTop: $("#composer-mon-panier").offset().top
                    }, 2000);
                }
                else {
                    // hide all elements that don't share ourClass
                    $('.full-products').children('div:not(.' + ourClass + ')').hide();
                    // show all elements that do share ourClass
                    $('.full-products').children('div.' + ourClass).show();
                }
                return false;
            }});
          });
    
    /*----------------------------
    	Cart Plus Minus Button
    ------------------------------ */
    var CartPlusMinus = $('.cart-plus-minus');
    CartPlusMinus.prepend('<div class="dec qtybutton">-</div>');
    CartPlusMinus.append('<div class="inc qtybutton">+</div>');
    $(".qtybutton").on("click", function() {
        var $button = $(this);
        var oldValue = $button.parent().find("input").val();
        if ($button.text() === "+") {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 0) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find("input").val(newVal);
    });
 
    /*------ Wow Active ----*/
    // new WOW().init();

    /*--------------------------
        ScrollUp
    ---------------------------- */
    // $.scrollUp({
    //     scrollText: '<i class="bi bi-arrow-up"></i>',
    //     easingType: 'linear',
    //     scrollSpeed: 900,
    //     animation: 'fade'
    // });
    
    /*--
    Smooth Scroll
    -----------------------------------*/
    $('.scroll-bottom').on('click', function(e) {
        e.preventDefault();
        var link = this;
        $.smoothScroll({
            offset: 0,
            scrollTarget: link.hash
        });
    });


    
})(jQuery);


    // let btn = document.getElementById('timeout');

    // btn.addEventListener('change',() => {
    //     x = document.getElementById('timeout').value;
    //     let rates = document.getElementsByName('time[]');
    //     rates.forEach((rate) => {
            
    //             rate.value = x;
            
    //     })
    // });   