@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Utilisateurs</a> <a href="#" class="current">Voir les utilisateurs</a> </div>
        <h1>Utilisateurs</h1>

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
                        <h5>Voir les utilisateurs</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID de l'utilisateur</th>
                                    <th>Nom</th>
                                    <th>Adresse</th>
                                    <th>ville</th>
                                    <th>Département</th>
                                    <th>Pays</th>
                                    <th>Code postal</th>
                                    <th>Mobile</th>
                                    <th>Email</th>
                                    <th>Statut</th>
                                    <th>Enreggistré le</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr class="gradeX">
                                    <td class="center">{{ $user->id }}</td>
                                    <td class="center">{{ $user->name }}</td>
                                    <td class="center">{{ $user->address }}</td>
                                    <td class="center">{{ $user->city }}</td>
                                    <td class="center">{{ $user->state }}</td>
                                    <td class="center">{{ $user->country }}</td>
                                    <td class="center">{{ $user->pincode }}</td>
                                    <td class="center">{{ $user->mobile }}</td>
                                    <td class="center">{{ $user->email }}</td>
                                    <td class="center">
                                        @if($user->status==1)
                                          <span class=" text-green-400">Active</span>
                                        @else
                                          <span class=" text-red-400">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="center">{{ $user->created_at->format('d-m-Y H:i:s') }}</td>
                                    
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