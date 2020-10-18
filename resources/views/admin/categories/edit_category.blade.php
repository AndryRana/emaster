@extends('layouts.adminLayout.admin_design')

@section('content')
    
<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i class="icon-home"></i>
                Accueil</a> <a href="#">Catégories</a> <a href="#" class="current">Modifier la catégorie</a> </div>
        <h1>Catégories</h1>
    </div>
    <div class="container-fluid">
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"> <i class="icon-info-sign"></i> </span>
                        <h5>Modifier la catégorie</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <form class="form-horizontal" method="post" action="{{ url('/admin/edit-category/' . $categoryDetails->id) }}" 
                        name="add_category" id="add_category" novalidate="novalidate">
                            @csrf
                            <div class="control-group">
                                <label class="control-label">Nom de la catégorie</label>
                                <div class="controls">
                                    <input type="text" name="category_name" id="category_name" value="{{ $categoryDetails->name }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Niveau de la catégorie</label>
                                <div class="controls">
                                    <select name="parent_id" style="width: 220px" >
                                        <option value="0">Catégorie principale</option>
                                        @foreach ($levels as $val)
                                            <option value="{{ $val->id }}" @if($val->id == $categoryDetails->parent_id) selected @endif>{{ $val->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Description</label>
                                <div class="controls">
                                    <textarea type="text" name="description" id="description" rows="5">{{ $categoryDetails->description }}</textarea>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">URL</label>
                                <div class="controls">
                                    <input type="text" name="url" id="url" value="{{ $categoryDetails->url }}">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Meta titre</label>
                                <div class="controls">
                                    <input type="text" name="meta_title" id="meta_title" value="{{ $categoryDetails->meta_title }}">
                                </div>
                            </div> 
                            <div class="control-group">
                                <label class="control-label">Meta Description</label>
                                <div class="controls">
                                    <input type="text" name="meta_description" id="meta_description" value="{{ $categoryDetails->meta_description }}"">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Meta Mot clés</label>
                                <div class="controls">
                                    <input type="text" name="meta_keywords" id="meta_keywords" value="{{ $categoryDetails->meta_keywords }}"">
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Afficher</label>
                                <div class="controls">
                                    <input type="checkbox" name="status" id="status" @if($categoryDetails->status=="1") checked
                                    @endif value="1" >
                                </div>
                            </div>
                            <div class="form-actions">
                                <input type="submit" value="Ajouter la catégorie" class="btn btn-success">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection