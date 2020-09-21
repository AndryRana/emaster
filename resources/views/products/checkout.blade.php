@extends('layouts.frontLayout.front_design')

@section('content')

<section id="form" style="margin-top: 20px;">
    <!--form-->
    <div class="container">
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
                            <input name="billing_name" id="billing_name" value="{{ $userDetails->name }}" type="text" placeholder="Nom sur la facture" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="billing_address" id="billing_address" value="{{ $userDetails->address }}"  type="text" placeholder="Adresse" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="billing_city" id="billing_city" value="{{ $userDetails->city }}"  type="text" placeholder="Ville " class="form-control" />
                        </div>

                        <div class="form-group">
                            <input name="billing_state" id="billing_state" value="{{ $userDetails->state }}"  type="text" placeholder="Région" class="form-control" />
                        </div>
                        <div class="form-group">
                            <select id="billing_country" name="billing_country" type="text" class=" form-control">
                                <option value="">Selectionner le pays</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country_name }}" @if ($country->country_name==$userDetails->country) selected
                                        @endif>{{ $country->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input name="billing_pincode" id="billing_pincode" value="{{ $userDetails->pincode }}"  type="text" placeholder="Code postal" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="billing_mobile" id="billing_mobile" value="{{ $userDetails->mobile }}"  type="text" placeholder="Téléphone mobile" class="form-control" />
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
                    <div class="signup-form">
                        <h2>Adresse de livraison</h2>
                        <div class="form-group">
                            <input name="shipping_name" id="shipping_name" value="{{ $shippingDetails->name }}" type="text" placeholder="Nom sur la livraison" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="shipping_address" id="shipping_address" value="{{ $shippingDetails->address }}" type="text" placeholder="Adresse" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="shipping_city" id="shipping_city" value="{{ $shippingDetails->city }}" type="text" placeholder="Ville" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="shipping_state" id="shipping_state" value="{{ $shippingDetails->state }}" type="text" placeholder="Région" class="form-control" />
                        </div>
                        <div class="form-group">
                            <select id="shipping_country" name="shipping_country" type="text" class=" form-control">
                                <option value="">Selectionner le pays</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->country_name }}" @if ($country->country_name==$userDetails->country) selected
                                        @endif>{{ $country->country_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <input name="shipping_pincode" id="shipping_pincode" value="{{ $shippingDetails->pincode }}" type="text" placeholder="Code postal" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input name="shipping_mobile" id="shipping_mobile" value="{{ $shippingDetails->mobile }}" type="text" placeholder="Téléphone mobile" class="form-control" />
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