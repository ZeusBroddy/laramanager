@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.categories'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Nova Categoria</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">{{ __('adminlte::menu.categories') }}</a></li>
                <li class="breadcrumb-item active">Nova Categoria</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Categoria</h3>
    </div>
    <form action="{{ route('categories.store') }}" class="form" method="POST">
        @csrf

        @include('admin.pages.categories._partials.form')
    </form>
</div>
@stop

@section('footer')
    @include('admin.components.footer')
@stop

