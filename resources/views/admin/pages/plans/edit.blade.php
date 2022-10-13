@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.plans'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Editar Plano</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">{{ __('adminlte::menu.plans') }}</a></li>
                <li class="breadcrumb-item active">Editar Plano</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Plano</h3>
        </div>
        <form action="{{ route('plans.update', $plan->id) }}" class="form" method="POST">
            @csrf
            @method('PUT')

            @include('admin.pages.plans._partials.form')
        </form>
    </div>
@stop

@section('footer')
    @include('admin.components.footer')
@stop
