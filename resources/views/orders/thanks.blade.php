@extends('layouts.frontLayout.front_design')

@section('content')
<section id="cart_items">
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ asset('/') }}">Accueil</a></li>
                <li class="active">Merci</li>
            </ol>
        </div>
    </div>
</section>

<section id="do_action">
    <div class="container">
        <div class="heading flex flex-col items-center">
            <h1 class="text-6xl">Merci!</h1>
            <h3>Votre paiement a bien été prise en compte </h3>
            <p class="my-6">Votre commande va vous être envoyée</p>
            <p class="my-3">Un email de confirmation vous a été envoyé</p>
            <a href="{{ asset('/') }}" class="bg-orange-400 hover:bg-gray-300 text-white py-2 px-4 my-6 w-100 ">Continuer vers la boutique</a>
        </div>
    </div>
</section>
@endsection

<?php
session()->forget('grand_total');
session()->forget('order_id'); 
?>