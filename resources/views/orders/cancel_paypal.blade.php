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
        <div class="heading" align="center">
            <h3>VOTRE PAIEMENT SUR PAYPAL A ÉTÉ ANNULÉ </h3>
            <p>Merci de bien vouloir nous contacter si vous avez plus de renseignement .</p>
        </div>
    </div>
</section>
@endsection

<?php
session()->forget('grand_total');
session()->forget('order_id'); 
?>