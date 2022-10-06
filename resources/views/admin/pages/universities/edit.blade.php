@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.universities'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Editar Faculdade</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('universities.index') }}">{{ __('adminlte::menu.universities') }}</a></li>
                <li class="breadcrumb-item active">Editar Faculdade</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Faculdade</h3>
        </div>
        <form action="{{ route('universities.update', $university->id) }}" class="form" enctype="multipart/form-data"
            method="POST">
            @csrf
            @method('PUT')

            @include('admin.pages.universities._partials.form')
        </form>
    </div>
@stop

@section('footer')
    @include('admin.components.footer')
@stop
