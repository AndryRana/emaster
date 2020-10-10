@extends('layouts.frontLayout.front_design')

@section('content')

<section id="form" style="margin-top: 20px;">
    <!--form-->
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="{{ asset('/') }}">Accueil</a></li>
                {{-- <i class="fa fa-home"></i> --}}
                <li class="active">Passer la commande</li>
            </ol>
        </div>
        <form action="{{ url('/checkout') }}" method="POST">
            @csrf
            <div class="row">
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
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form ">
                        <h2>Adresse de facturation</h2>
                        <div class="form-group">
                            <input name="billing_name" id="billing_name" @if(!empty($userDetails->name)) value="{{ $userDetails->name }}" @endif type="text" placeholder="Nom sur la facture" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="billing_address" id="billing_address" @if (!empty($userDetails->address)) value="{{ $userDetails->address }}" @endif type="text" placeholder="Adresse" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="billing_city" id="billing_city" @if(!empty($userDetails->city)) value="{{ $userDetails->city }}" @endif  type="text" placeholder="Ville " class="form-control" />
                        </div>

                        <div class="form-group">
                            <input name="billing_state" id="billing_state" @if(!empty($userDetails->state)) value="{{ $userDetails->state }}" @endif  type="text" placeholder="Région" class="form-control" />
                        </div>
                        <div class="form-group">
                            <select id="billing_country" name="billing_country" type="text" class=" form-control">
                                <option value="">Selectionner le pays</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country_name }}" @if(!empty($userDetails->country) && $country->country_name == $userDetails->country) selected @endif>
                                        {{ $country->country_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input name="billing_pincode" id="billing_pincode" @if(!empty($userDetails->pincode)) value="{{ $userDetails->pincode }}" @endif  type="text" placeholder="Code postal" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="billing_mobile" id="billing_mobile" @if(!empty($userDetails->mobile)) value="{{ $userDetails->mobile }}" @endif type="text" placeholder="Téléphone mobile" class="form-control" />
                        </div>
                        <div class="form-check">
                            <input  type="checkbox" class="form-check-input" id="billtoship">
                            <label class="form-check-label" for="billtoship">Utiliser comme adresse de livraison</label>
                        </div>
                    </div>
                </div>
                <div class="col-sm-1">
                    <h2></h2>
                </div>
                <div class="col-sm-4">
                    <div class="login-form">
                        <h2>Adresse de livraison</h2>
                        <div class="form-group">
                            <input name="shipping_name" id="shipping_name" @if(!empty($shippingDetails->name)) value="{{ $shippingDetails->name }}" @endif type="text" placeholder="Nom sur la livraison" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="shipping_address" id="shipping_address" @if(!empty($shippingDetails->address)) value="{{ $shippingDetails->address }}" @endif type="text" placeholder="Adresse" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="shipping_city" id="shipping_city" @if(!empty($shippingDetails->city)) value="{{ $shippingDetails->city }}" @endif type="text" placeholder="Ville" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="shipping_state" id="shipping_state" @if(!empty($shippingDetails->state)) value="{{ $shippingDetails->state }}" @endif type="text" placeholder="Région" class="form-control" />
                        </div>
                        <div class="form-group">
                            <select id="shipping_country" name="shipping_country" type="text" class=" form-control">
                                <option value="">Selectionner le pays</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country_name }}"@if(!empty($shippingDetails->country) && $country->country_name == $shippingDetails->country) selected @endif>
                                        {{ $country->country_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input name="shipping_pincode" id="shipping_pincode" @if(!empty($shippingDetails->pincode)) value="{{ $shippingDetails->pincode }}" @endif type="text" placeholder="Code postal" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="shipping_mobile" id="shipping_mobile" @if(!empty($shippingDetails->mobile)) value="{{ $shippingDetails->mobile }}" @endif type="text" placeholder="Téléphone mobile" class="form-control" />
                        </div>
                        <button type="submit" class="btn btn-default">Continuer</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</section>
<!--/form-->

@endsection