@extends('layouts.frontLayout.front_design')

@section('content')


<section id="form">
    <!--form-->
    <div class="container">
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
                <div class="login-form">
                   
                    <h2>Modifier mon compte</h2>
                    <form id="accountForm" name="accountForm" action="{{ url('/account') }}"  method="POST">
                        @csrf
                        <input value="{{ $userDetails->name }}" id="name" name="name" type="text" placeholder="Nom" />
                        <input value="{{ $userDetails->address }}" id="address" name="address" type="text" placeholder="Adresse" />
                        <input value="{{ $userDetails->city }}" id="city" name="city" type="text" placeholder="Ville" />
                        <input value="{{ $userDetails->state }}" id="state" name="state" type="text" placeholder="Région" />
                        <select id="country" name="country" type="text" >
                            <option value="">Selectionner le pays</option>
                            @foreach ($countries as $country)
                                <option value="{{ $country->country_name }}" @if ($country->country_name==$userDetails->country) selected
                                    @endif>{{ $country->country_name }}</option>
                            @endforeach
                        </select>
                        <input value="{{ $userDetails->pincode }}" style="margin-top: 10px;" id="pincode" name="pincode" type="text" placeholder="Code postal" />
                        <input value="{{ $userDetails->mobile }}" id="mobile" name="mobile" type="text" placeholder="Téléphone mobile" />
                        <button type="submit" class="btn btn-default">Modifier</button>
                    </form>
                </div>
             
            </div>
            <div class="col-sm-1">
                <h2 class="or">OU</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">
                    <h2>Modifier votre mot de passe</h2>
                    <form id="passwordForm" name="passwordForm" action="{{ url('/update-user-pwd') }}" method="post">
                    @csrf
                    <input type="password" name="current_pwd" id="current_pwd" placeholder="Mot de passe actuel">
                    <span id="chkPwd"></span>
                    <input type="password" name="new_pwd" id="new_pwd" placeholder="Nouveau mot de passe">
                    <input type="password" name="confirm_pwd" id="confirm_pwd" placeholder="Confirmer le mot de passe">
                    <button type="submit" class="btn btn-default">Modifier le mot de passe</button>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</section>
<!--/form-->

@endsection