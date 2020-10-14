@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">CMS Pages</a> <a href="#" class="current">Modifier le CMS Page</a> </div>
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
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Modifier un CMS Page</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form enctype="multipart/form-data" class="form-horizontal" method="post"
                            action="{{ url('/admin/edit-cms-page/'.$cmsPage->id) }}" name="add-cms-page"
                            id="add-cms-page" novalidate="novalidate">
                            @csrf

                            <div class="control-group">
                                <label class="control-label">Titre</label>
                                <div class="controls">
                                    <input class=" w-28" type="text" name="title" id="title" value="{{ $cmsPage->title }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">URL</label>
                                <div class="controls">
                                    <input type="text" name="url" id="url" value="{{ $cmsPage->url }}"">
                                </div>
                            </div>
                            <div class=" control-group">
                                    <label class="control-label">Description</label>
                                    <div class="controls">
                                        <textarea name="description">{{ $cmsPage->description }}</textarea>
                                    </div>
                                </div>
                                <div class="control-group">
                                    <label class="control-label">Afficher</label>
                                    <div class="controls">
                                        <input type="checkbox" name="status" id="status" @if($cmsPage->status=="1") checked @endif value="1">
                                    </div>
                                </div>
                                <div class="form-actions">
                                    <input type="submit" value="Ajouter un CMS Page" class="btn btn-success">
                                </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection