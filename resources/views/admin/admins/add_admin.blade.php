@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Admins/Sub-Admins</a> <a href="#" class="current">Ajouter Admin/Sub-Admin</a>
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
                        <h5>Ajouter Admin/Sub-Admin</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{ url('/admin/add-admin') }}"
                            name="add-admin" id="add-admin" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Type</label>
                                <div class="controls leading-8 ">
                                    <select name="type" id="type" style="width: 220px;">
                                        <option value="Admin">Admin</option>
                                        <option value="Sub Admin">Sub Admin</option>
                                    </select>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Pseudo Admin/Sub-Admin</label>
                                    <div class="controls leading-8 ">
                                        <input type="text" name="username" id="username" required>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Mot de passe</label>
                                    <div class="controls leading-8">
                                        <input type="password" name="password" id="password" required></input>
                                    </div>
                                </div>
                                <div class="control-group" id="access">
                                    <label class="control-label leading-3">Accès autorisés</label>
                                    <div class="controls flex flex row">
                                        <div class="flex flex-row mr-5"><input type="checkbox" name="categories_view_access"
                                                id="categories_view_access" value="1"> <span class="ml-1">Voir Categories </span>
                                        </div>
                                        <div class="flex flex-row mr-5"><input type="checkbox" name="categories_edit_access"
                                                id="categories_edit_access" value="1"> <span class="ml-1">Voir et Modifier Categories</span>
                                        </div>
                                        <div class="flex flex-row mr-5"><input type="checkbox" name="categories_full_access"
                                                id="categories_full_access" value="1"> <span class="ml-1">Voir, Modifier et Supprimer Categories</span>
                                        </div>
                                        <div class="flex flex-row mr-5"><input type="checkbox" name="products_access"
                                                id="products_access" value="1"> <span class="ml-1">Produits</span>
                                        </div>
                                        <div class="flex flex-row mr-5"><input type="checkbox" name="orders_access"
                                                id="orders_access" value="1"> <span class="ml-1">Commandes</span> </div>
                                        <div class="flex flex-row mr-5"><input type="checkbox" name="users_access"
                                                id="users_access" value="1"> <span class="ml-1">Utilisateurs</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label leading-3">Afficher</label>
                                    <div class="controls">
                                        <input type="checkbox" name="status" id="status" value="1">
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="submit" value="Ajouter Admin/Sub-Admin" class="btn btn-success">
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection