@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">CMS Pages</a> <a href="#" class="current">Voir les CMS Pages</a> </div>
        <h1>CMS Pages</h1>

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
                        <h5>CMS Pages</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Titre</th>
                                    <th>URL</th>
                                    <th>Statut</th>
                                    <th>Date de création</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($cmsPages as $page)
                                <tr class="gradeX">
                                    <td>{{ $page->id }}</td>
                                    <td>{{ $page->title}}</td>
                                    <td>{{ $page->url }}</td>
                                    <td>@if($page->status==1) Activé @else Inactive @endif</td></td>
                                    <td>{{ $page->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="center">
                                        <a href="#myModal{{ $page->id }}" data-toggle="modal"
                                            class="btn btn-success btn-mini" title="Voir">Détails</a>

                                        <a href="{{ url('/admin/edit-cms-page/' .$page->id) }}"
                                            class="btn btn-primary btn-mini" title="Modifier">Modifier</a>

                                        <a href="{{ url('/admin/delete-cms-page/'.$page->id) }}""
                                            class="btn btn-danger btn-mini" title="Supprimer" >Supprimer</a>
                                    </td>
                                </tr>

                                <div id="myModal{{ $page->id }}" class="modal hide">
                                    <div class="modal-header">
                                        <button data-dismiss="modal" class="close" type="button">×</button>
                                        <h3>Les détails du {{ $page->title }} </h3>
                                    </div>
                                    <div class="modal-body">
                                        <p><strong>Titre:</strong> {{ $page->title }}</p>
                                        <p><strong>URL:</strong> {{ $page->url }}</p>
                                        <p><strong>Status:</strong> @if($page->status==1) Activé @else Inactive @endif</p>
                                        <p><strong>Date de création:</strong> {{ $page->created_at->format('d-m-Y H:i:s') }}</p>
                                        <p><strong>Description:</strong> {{ $page->description }}</p>
                                    </div>
                                </div>

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