@extends('layouts.frontLayout.front_design')

@section('content')

<section id="form" style="margin-top: 20px;">
    <!--form-->
    <div class="container">
        <form action="#">
            @csrf
            <div class="row">
                <div class="col-sm-4 col-sm-offset-1">
                    <div class="login-form ">
                        <h2>Adresse de facturation</h2>
                        <div class="form-group">
                            <input type="text" placeholder="Nom sur la facture" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Adresse" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Ville " class="form-control" />
                        </div>

                        <div class="form-group">
                            <input type="text" placeholder="Région" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Pays" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Code postal" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Téléphone mobile" class="form-control" />
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="billtoship">
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
                            <input type="text" placeholder="Nom sur la livraison" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Adresse" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Ville" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Région" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Pays" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Code postal" class="form-control" />
                        </div>
                        <div class="form-group">
                            <input type="text" placeholder="Téléphone mobile" class="form-control" />
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