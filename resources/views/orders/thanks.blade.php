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
            <h3>VOTRE PAIEMENT A BIEN ÉTÉ TRAITÉ </h3>
            <p>Votre numéro de commande est le {{session()->get('order_id')}} et le montant total payé est de {{ number_format(session()->get('grand_total'), 2, ',', ' ') . ' €' }}</p>
        </div>
    </div>
</section>
@endsection

<?php
session()->forget('grand_total');
session()->forget('order_id'); 
?>