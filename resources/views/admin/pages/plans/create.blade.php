@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.plans'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Novo Plano</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">{{ __('adminlte::menu.plans') }}</a></li>
                <li class="breadcrumb-item active">Novo Plano</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Plano</h3>
    </div>
    <form action="{{ route('plans.store') }}" class="form" method="POST">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label for="">Nome:</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Digite o nome" value="{{ old('name') }}">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Intervalo:</label>
                <input type="text" name="interval" class="form-control @error('interval') is-invalid @enderror"
                    placeholder="Digite qual o intervalo de cobrança" value="{{ old('interval') }}">

                @error('interval')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Valor:</label>
                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                    placeholder="Digite o valor" value="{{ old('amount') }}">

                @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Salvar</button>
        </div>
    </form>
</div>
@stop

@section('footer')
    @include('admin.components.footer')
@stop
