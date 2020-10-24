@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Admins/Sub-Admins</a> <a href="#" class="current">Modifier Admin/Sub-Admin</a>
        </div>
        <h1>Admin/Sub-Admin</h1>

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
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Modifier Admin/Sub-Admin</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{ url('/admin/edit-admin/'.$adminDetails->id) }}"
                            name="edit-admin" id="edit-admin" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Type</label>
                                <div class="controls leading-8 ">
                                    <input type="text" name="type" id="type" readonly value="{{ $adminDetails->type }}">
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Pseudo Admin/Sub-Admin</label>
                                    <div class="controls leading-8 ">
                                        <input type="text" name="username" id="username" readonly value="{{ $adminDetails->username }}">
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Mot de passe</label>
                                    <div class="controls leading-8">
                                        <input type="password" name="password" id="password" required="" ></input>
                                    </div>
                                </div>
                                @if ($adminDetails->type=="Sub Admin")
                                    <div class="control-group">
                                        <label class="control-label leading-3">Accès autorisés</label>
                                        <div class="controls flex">
                                            <div class="flex flex-row mr-5">
                                                <input type="checkbox" name="categories_view_access" id="categories_view_access" value="1" @if ($adminDetails->categories_view_access=="1") checked @endif> 
                                                <span class="ml-1">Voir Categories</span>
                                            </div>
                                            <div class="flex flex-row mr-5">
                                                <input type="checkbox" name="categories_edit_access" id="categories_edit_access" value="1" @if ($adminDetails->categories_edit_access=="1") checked @endif> 
                                                <span class="ml-1">Voir et Modifier Categories</span>
                                            </div>
                                            <div class="flex flex-row mr-5">
                                                <input type="checkbox" name="categories_full_access" id="categories_full_access" value="1" @if ($adminDetails->categories_full_access=="1") checked @endif> 
                                                <span class="ml-1">Voir, Modifier et Supprimer Categories</span>
                                            </div>
                                            <div class="flex flex-row mr-5">
                                                <input type="checkbox" name="products_access" id="products_access" value="1" @if ($adminDetails->products_access=="1") checked @endif> 
                                                <span class="ml-1">Produits</span>
                                            </div>
                                            <div class="flex flex-row mr-5">
                                                <input type="checkbox" name="orders_access" id="orders_access" value="1" @if ($adminDetails->orders_access=="1") checked @endif> 
                                                <span class="ml-1">Commandes</span> 
                                            </div>
                                            <div class="flex flex-row mr-5">
                                                <input type="checkbox" name="users_access" id="users_access" value="1" @if ($adminDetails->users_access=="1") checked @endif> 
                                                <span class="ml-1">Utilisateurs</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="control-group">
                                    <label class="control-label leading-3">Afficher</label>
                                    <div class="controls">
                                        <input type="checkbox" name="status" id="status" value="1" @if ($adminDetails->status=="1") checked @endif>
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="submit" value="Modifier Admin/Sub-Admin" class="btn btn-success">
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection