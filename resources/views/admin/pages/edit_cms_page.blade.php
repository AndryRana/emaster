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
    <form class="w-full max-w-sm">
    <div class="md:flex md:items-center mb-6">
        <div class="md:w-1/3">
          <label class="block text-gray-500 font-bold md:text-right mb-1 md:mb-0 pr-4" for="inline-full-name">
            Full Name
          </label>
        </div>
        <div class="md:w-2/3">
          <input class="bg-gray-200 appearance-none border-2 border-gray-200 rounded w-full py-2 px-4 text-gray-700 leading-tight focus:outline-none focus:bg-white focus:border-purple-500" id="inline-full-name" type="text" value="Jane Doe">
        </div>
      </div>
    </form>
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
                                    <input class=" w-28" type="text" name="title" id="title"
                                        value="{{ $cmsPage->title }}">
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
                                    <textarea name="description" rows="10">{{ $cmsPage->description }}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Meta titre</label>
                                <div class="controls">
                                    <input type="text" name="meta_title" id="meta_title" value="{{ $cmsPage->meta_title }}">
                                </div>
                            </div> 
                            <div class="control-group">
                                <label class="control-label">Meta Description</label>
                                <div class="controls">
                                    <input type="text" name="meta_description" id="meta_description" value="{{ $cmsPage->meta_description }}"">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Meta Mot clés</label>
                                <div class="controls">
                                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ $cmsPage->meta_keywords }}"">
                                </div>
                            </div>
                            
                            <div class="control-group">
                                <label class="control-label">Afficher</label>
                                <div class="controls">
                                    <input type="checkbox" name="status" id="status" @if($cmsPage->status=="1")
                                    checked @endif value="1">
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