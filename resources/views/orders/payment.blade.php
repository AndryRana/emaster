@extends('layouts.frontLayout.front_design')

@section('stripe-js')
    <script src="https://js.stripe.com/v3/"></script>
@endsection
@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ asset('/') }}">Accueil</a></li>
                <li class="active">Paiement</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="flex flex-col items-center text-center">
        @if (Session::has('flash_message_error'))
        <div class="alert alert-danger alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_error') !!}</strong>
        </div>
        @endif

        @if (Session::has('flash_message_success'))
        <div class="alert alert-success alert-block">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>{!! session('flash_message_success') !!}</strong>
        </div>
        @endif
        <h1 class="text-3xl font-normal">Votre numéro de commande est le {{session()->get('order_id')}} et le montant
            total de la commande est de
            {{ number_format(session()->get('grand_total'), 2, ',', ' ') . ' €' }}</h1>
        <p class="text-3xl my-10">Veuillez compléter le présent formulaire pour procéder au paiement par carte bancaire
        </p>
        <p class="text-2xl text-orange-300 my-10 w-3/12">
            Nous ne conservons aucune de ces informatios sur notre site, elles sont directement transmises à notre
            prestataire de paiment Stripe.
            La transmission de ces informations est entièrement sécurisée.
        </p>
        <form action="{{ route('stripe.payment') }}" method="POST" id="payment-form" class="my-6 w-3/12 ">
            @csrf
            <input type="hidden" name="order_id" value="{{ $orderDetails->id  }}" id="order_id">
            <input type="hidden" name="grand_total" value="{{ $orderDetails->grand_total  }}" id="grand_total">
            <input type="hidden" name="user_email" value="{{ $orderDetails->user_email  }}" id="user_email">
            <input type="hidden" name="user_name" value="{{ $orderDetails->name  }}" id="user_name">
            <input type="hidden" name="address" value="{{ $orderDetails->address  }}" id="address">
            <input type="hidden" name="country" value="{{ $orderDetails->country  }}" id="country">
            <input type="hidden" name="pincode" value="{{ $orderDetails->pincode  }}" id="pincode">
            <input type="hidden" name="city" value="{{ $orderDetails->city  }}" id="city">
            <input type="hidden" name="state" value="{{ $orderDetails->state  }}" id="state">
          
            <div class="form-group">
                <label for="card-element" class="flex text-2xl font-normal">
                    Carte de crédit ou de débit
                </label>
                <div id="card-element" class="border-solid border-2 border-gray-300 py-4 px-2">

                </div>

                <!-- We'll put the error messages in this element -->
                <div id="card-errors" role="alert"></div>
            </div>
            <button type="submit" class=" buttonspin bg-orange-400 hover:bg-gray-300 text-white py-2 px-4 my-6 "
                id="complete-order">
                <i class="loading-icon fa fa-spinner fa-spin hide"></i>
                <span class="btn-txt">Procéder au paiement (
                    {{ number_format(session()->get('grand_total'), 2, ',', ' ') . ' €' }})</span>
            </button>
        </form>
        <div class="my-10">
            <span> <img src="{{ asset('images/frontend_images/credit-card/site-paiement-securise.png') }}"
                    alt="Paiement sécurisé" style="width: 250px;"></span>
        </div>

    </div>
</section>

@endsection

<?php
session()->forget('grand_total');
session()->forget('order_id'); 
?>
@section('extra-js')
<script>
    (function(){
        // Create a Stripe client.
        var stripe = Stripe('{{ config('services.stripe.publishable_key') }}');

        // Create an instance of Elements.
        var elements = stripe.elements();

        // Custom styling can be passed to options when creating an Element.
        // (Note that this demo uses a wider set of styles than the guide below.)
        var style = {
            base: {
            color: "#32325d",
            fontFamily: '"Helvetica Neue", Helvetica, sans-serif',
            fontSmoothing: "antialiased",
            fontSize: "16px",
            "::placeholder": {
                color: "#aab7c4"
            }
            },
            invalid: {
            color: "#fa755a",
            iconColor: "#fa755a"
            }
    };

        // Create an instance of the card Element.
        var card = elements.create("card", { 
            style: style,
            hidePostalCode: true
        });

        // Add an instance of the card Element into the `card-element` <div>.
        card.mount("#card-element");

       // Handle real-time validation errors from the card Element.
        card.on('change', function(event) {
            var displayError = document.getElementById('card-errors');
            if (event.error) {
                displayError.classList.add('alert','alert-warning');
                displayError.textContent = event.error.message;
            } else {
                displayError.classList.remove('alert','alert-warning');
                displayError.textContent = '';
            }
        });
        // Handle form submission.
        var form = document.getElementById('payment-form');

        form.addEventListener('submit', function(ev) {
            ev.preventDefault();
            // form.disabled = true;
            document.getElementById('complete-order').disabled = true;
        
            document.querySelector('.loading-icon').classList.remove('hide');
            document.querySelector('.buttonspin').getAttribute('disabled', true);
            document.querySelector('.btn-txt').innerHTML = 'Paiement en cours...';

            setTimeout(function(){
                document.querySelector('.loading-icon').classList.add('hide');
                document.querySelector('.buttonspin').getAttribute('disabled', false);
                document.querySelector('.btn-txt').innerHTML = 'Procéder au paiement {{ number_format(session()->get('grand_total'), 2, ',', ' ') . ' €'  }}';
            }, 5000);
   
        // stripe.confirmCardPayment("{{ $clientSecret ?? '' }}", {
        //     payment_method: {
        //         card: card,
        //         billing_details: {
        //             address: {
        //                 line1: '{{ $orderDetails->address }}',
        //                 line2: '{{  $orderDetails->country}}',
        //                 postal_code: '{{ $orderDetails->pincode }}',
        //                 city: '{{ $orderDetails->city }}',
        //                 state: '{{ $orderDetails->state }}',
        //             },
        //             name: '{{ $orderDetails->name }}'
        //         }
        //     }
        // })
        // .then(function(result) {
        //     if (result.error) {
        //     // Show error to your customer (e.g., insufficient funds)
        //     form.disabled = false;
        //     console.log(result.error.message);
        //     } else {
        //         // The payment has been processed!
        //         if (result.paymentIntent.status === 'succeeded') {
        //             var paymentIntent = result.paymentIntent;
        //             var token =  document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        //             var form = document.getElementById('payment-form');
        //             var url = form.action;
        //             var redirect = '/thanks'

        //             fetch(
        //                 url,
        //                 {
        //                     headers: {
        //                         "Content-Type": "application/json",
        //                         "Accept": "application/json, text-plain, */*",
        //                         "X-Request-With": "XMLHttpRequest",
        //                         "X-CSRF-TOKEN": token
        //                     },
        //                     method: 'POST',
        //                     body: JSON.stringify({
        //                         paymentIntent:paymentIntent
        //                     })
        //                 }
        //             ).then((data)=>{
        //                 console.log(data)
        //                 window.location.href = redirect;

        //             }).catch((error)=>{
        //                 console.log(error)
        //             })
        //         }
        //     }
        // });
            var options = {
                name: document.getElementById('user_name').value,
                address_line1: document.getElementById('address').value,
                address_city: document.getElementById('city').value,
                address_state: document.getElementById('state').value,
                address_zip: document.getElementById('pincode').value,
                address_country: document.getElementById('country').value,
            }
            stripe.createToken(card, options).then(function(result) {
                if (result.error) {
                // Inform the user if there was an error
                var errorElement = document.getElementById('card-errors');
                errorElement.textContent = result.error.message;

                // Enable the submit button
                document.getElementById('complete-order').disabled = false;
                } else {
                // Send the token to your server
                console.log(result.token);
                stripeTokenHandler(result.token);
                }
            });
        });
        function stripeTokenHandler(token) {
            // Insert the token ID into the form so it gets submitted to the server
            var form = document.getElementById('payment-form');
            var hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'stripeToken');
            hiddenInput.setAttribute('value', token.id);
            form.appendChild(hiddenInput);
            
            // Submit the form
            form.submit();
        }

    })();
</script>
@endsection