@extends('layouts.adminLayout.admin_design')

@section('content')

<div id="content">
    <div id="content-header">
        <div id="breadcrumb"> <a href="index.html" title="Aller à l'accueil" class="tip-bottom"><i
                    class="icon-home"></i>
                Accueil</a> <a href="#">Newsletters</a> <a href="#" class="current">Voir les Abonnés Newsletter</a> </div>
        <h1>Newsletters</h1>

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
        <div>
            <a href="{{ url('/admin/export-newsletter-emails') }}" class="btn btn-primary btn-mini">Export</a>
        </div>
        <hr>
        <div class="row-fluid">
            <div class="span12">
                <div class="widget-box">
                    <div class="widget-title"> <span class="icon"><i class="icon-th"></i></span>
                        <h5>Voir les Abonnés Newsletter</h5>
                    </div>
                    <div class="widget-content nopadding">
                        <table class="table table-bordered data-table">
                            <thead>
                                <tr>
                                    <th>ID Abonné</th>
                                    <th>Email</th>
                                    <th>statut</th>
                                    <th>Enregistré le</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($newsletters as $newsletter)
                                <tr class="gradeX">
                                    <td class="center">{{ $newsletter->id }}</td>
                                    <td class="center">{{ $newsletter->email }}</td>
                                    <td class="center">
                                        @if($newsletter->status==1)
                                            <a href="{{ url('/admin/update-newsletter-status/'.$newsletter->id.'/0') }}" class="btn btn-default btn-mini"> <span class="text-success">Active</span></a>
                                        @else
                                            <a href="{{ url('/admin/update-newsletter-status/'.$newsletter->id.'/1') }}" class="btn btn-mini"> <span class="text-error">Inactive</span></a>
                                        @endif
                                    </td>
                                    <td class="center">{{ $newsletter->created_at->format('d-m-Y H:i:s') }}</td>
                                    <td class="center"><a id="delNewsletter" rel="{{ $newsletter->id }}" rel1="delete-newsletter-email"
                                        href="javascript:" class="btn btn-danger btn-mini deleteRecord" >Supprimer</td>
                                    </a> 
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