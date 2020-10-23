@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Admins/Sub-Admins</a> <a href="#" class="current">Voir les Admins/Sub-Admins</a> </div>
        <h1>Admins/Sub-Admins</h1>

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
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Voir les Admins/Sub-Adminss</h5>
                    </div>
                    <div class="widget-content nopadding ">
                        <table class="table table-bordered data-table ">
                            <thead >
                                    <th >ID de l'utilisateur</th>
                                    <th>Pseudo</th>
                                    <th>Type</th>
                                    <th>Rôle</th>
                                    <th>Statut</th>
                                    <th>Enregistré le</th>
                                    <th>Mise à jour le</th>
                                    <th>Actions</th>
                               
                                </tr>
                            </thead>
                            <tbody class="place-content-center">
                                @foreach ($admins as $admin)
                                <?php 
                                    if($admin->type=="Admin"){
                                    $roles = "Tout";
                                }else{
                                    $roles = "";
                                    if($admin->categories_access==1){
                                        $roles = "Categories, ";
                                    }
                                    if($admin->products_access==1){
                                        $roles = "Produits, ";
                                    }
                                    if($admin->orders_access==1){
                                        $roles = "Comandes, ";
                                    }
                                    if($admin->users_access==1){
                                        $roles = "Utilisateurs, ";
                                    }

                                } 
                                ?>
                                <tr class="gradeX">
                                    <td class="center">{{ $admin->id }}</td>
                                    <td class="center">{{ $admin->username }}</td>
                                    <td class="center">{{ $admin->type }}</td>
                                    <td class="center">{{ $roles }}</td>
                                    <td class="center">
                                        @if($admin->status==1)
                                          <span class="text-success">Active</span>
                                        @else
                                          <span class="text-error">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="center">{{ $admin->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="center">{{ $admin->updated_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="center"></td>
                                    
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection