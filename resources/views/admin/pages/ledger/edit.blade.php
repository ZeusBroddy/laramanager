@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.ledger'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Editar Registro</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('ledger.index') }}">{{ __('adminlte::menu.ledger') }}</a></li>
                <li class="breadcrumb-item active">Editar Registro</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Financeiro</h3>
        </div>
        <form action="{{ route('ledger.update', $entry->id) }}" class="form" method="POST">
            @csrf
            @method('PUT')

            @include('admin.pages.ledger._partials.form')
        </form>
    </div>
@stop

@section('footer')
    @include('admin.components.footer')
@stop

@section('js')
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
@stop
