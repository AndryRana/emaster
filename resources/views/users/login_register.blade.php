@extends('layouts.frontLayout.front_design')

@section('content')


<section id="form" style="margin-top: 20px;">
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
                    <!--login form-->
                    <h2>S'identifier</h2>
                    <form id="loginForm" name="loginForm"  action="{{ url('/user-login') }}" method="POST">
                        @csrf
                        <input name="email" type="email" placeholder="Adresse email" />
                        <input name="password" type="password" placeholder="Mot de passe" />
                        {{-- <span>
                            <input type="checkbox" class="checkbox">
                            Garder la connexion
                        </span> --}}
                        <button type="submit" class="btn btn-default">Continuer</button>
                    </form>
                </div>
                <!--/login form-->
            </div>
            <div class="col-sm-1">
                <h2 class="or">OU</h2>
            </div>
            <div class="col-sm-4">
                <div class="signup-form">
                    <!--sign up form-->
                    <h2>Créer un compte!</h2>
                    <form id="registerForm" name="registerForm" action="{{ url('/user-register') }}"  method="POST">
                        @csrf
                        <input id="name" name="name" type="text" placeholder="Nom" />
                        <input id="emamil" name="email" type="email" placeholder="Adresse email" />
                        <input id="myPassword" name="password" type="password" placeholder="Mot de passe" />
                        <button type="submit" class="btn btn-default">S'inscrire</button>
                    </form>
                </div>
                <!--/sign up form-->
            </div>
        </div>
    </div>
</section>
<!--/form-->

@endsection