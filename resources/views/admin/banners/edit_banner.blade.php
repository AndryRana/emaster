@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Bannières</a> <a href="#" class="current">Modifier la bannière</a> </div>
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
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Modifier la bannière</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post"
                            action="{{ url('/admin/edit-banner/'.$bannerDetails->id) }}" name="edit_banner"
                            id="edit_banner" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Image de la bannière</label>
                                <div class="controls">
                                    <div class="uploader" id="uniform-undefined"><input name="image" id="image"
                                            type="file" size="19" style="opacity: 0;">
                                        <span class="filename">Pas de fichier</span>
                                        <span class="action">Choisir l'image</span>
                                    </div>
                                    {{-- <input type="file" name="image" id="image"> --}}
                                    @if (!empty($bannerDetails->image))
                                        <input type="hidden" name="current_image" value="{{ $bannerDetails->image }}">
                                        <img style="width: 250px;"
                                            src="{{ asset('/images/frontend_images/banners/'. $bannerDetails->image) }}">
                                        
                                    @endif
                                </div>

                            </div>
                            <div class="control-group">
                                <label class="control-label">Titre </label>
                                <div class="controls">
                                    <input type="text" name="banner_title" id="banner_title"
                                        value="{{ $bannerDetails->title }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Lien</label>
                                <div class="controls">
                                    <input type="text" name="banner_link" id="banner_link"
                                        value="{{ $bannerDetails->link }}">
                                </div>
                            </div>

                            <div class="control-group">
                                <label class="control-label">Afficher</label>
                                <div class="controls">
                                    <input type="checkbox" name="status" id="status" value="1" @if($bannerDetails->status=="1") checked
                                    @endif>
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Ajouter une bannière" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection