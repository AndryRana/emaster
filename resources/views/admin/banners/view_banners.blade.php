@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Bannières</a> <a href="#" class="current">Voir les bannières</a> </div>
        <h1>Bannières</h1>

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
                        <h5>Voir les bannières</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID de la bannière</th>
                                    <th>Titre</th>
                                    <th>Lien</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($banners as $banner)
                                <tr class="gradeX">
                                    <td>{{ $banner->id }}</td>
                                    <td>{{ $banner->title}}</td>
                                    <td>{{ $banner->link }}</td>
                                    <td>
                                        @if (!empty($banner->image))
                                        <img src="{{ asset('/images/frontend_images/banners/'.$banner->image) }}"
                                            style="width: 250px;">
                                        @endif
                                    </td>
                                    <td>
                                        @if ($banner->status==1) Activé @else Désactivé @endif
                                    </td>
                                    <td class="center">
                                        <a href="{{ url('/admin/edit-banner/' .$banner->id) }}"
                                            class="btn btn-primary btn-mini" title="Modifier le bannières">Modifier</a>

                                        <a id="delbanner" rel="{{ $banner->id }}" rel1="delete-banner"
                                            <?php /*href="/admin/delete-banner/{{ $banner->id }}"*/ ?>
                                            href="javascript:"
                                            class="btn btn-danger btn-mini deleteRecord" title="Supprimer la bannière" >Supprimer</a>
                                    </td>
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