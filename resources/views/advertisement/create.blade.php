@extends('layouts.app')
@push('css_lib')
    <link rel="stylesheet" href="{{asset('public/vendor/icheck-bootstrap/icheck-bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/vendor/select2/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/vendor/summernote/summernote-bs4.min.css')}}">
    <link rel="stylesheet" href="{{asset('public/vendor/dropzone/min/dropzone.min.css')}}">
@endpush
@section('content')
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0 text-bold">{{trans('lang.advertisement_plural') }}<small class="mx-3">|</small><small>{{trans('lang.advertisement_desc')}}</small></h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb bg-white float-sm-right rounded-pill px-4 py-2 d-none d-md-flex">
                        <li class="breadcrumb-item"><a href="{{url('/dashboard')}}"><i class="fas fa-tachometer-alt"></i> {{trans('lang.dashboard')}}</a></li>
                        <li class="breadcrumb-item">
                            <a href="{!! route('advertisement.index') !!}">{{trans('lang.advertisement_plural')}}</a>
                        </li>
                        <li class="breadcrumb-item active">{{trans('lang.advertisement_create')}}</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->
    <div class="content">
        <div class="clearfix"></div>
        @include('flash::message')
        @include('adminlte-templates::common.errors')
        <div class="clearfix"></div>
        <div class="card shadow-sm">
            <div class="card-header">
                <ul class="nav nav-tabs d-flex flex-row align-items-start card-header-tabs">
                    @can('advertisement.index')
                        <li class="nav-item">
                            <a class="nav-link" href="{!! route('advertisement.index') !!}"><i class="fa fa-list mr-2"></i>{{trans('lang.advertisement_table')}}</a>
                        </li>
                    @endcan
                    <li class="nav-item">
                        <a class="nav-link active" href="{!! url()->current() !!}"><i class="fa fa-plus mr-2"></i>{{trans('lang.advertisement_create')}}</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                {!! Form::open(['route' => 'advertisement.store']) !!}
                <div class="row">
                    @include('advertisement.fields')
                </div>
                {!! Form::close() !!}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    @include('layouts.media_modal')
@endsection
@push('scripts_lib')
    <script src="{{asset('public/vendor/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('public/vendor/summernote/summernote.min.js')}}"></script>
    <script src="{{asset('public/vendor/dropzone/min/dropzone.min.js')}}"></script>
    <script type="text/javascript">
        Dropzone.autoDiscover = false;
        var dropzoneFields = [];
    </script>
@endpush
