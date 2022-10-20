@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.users'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Criar Mensalidade</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('adminlte::menu.users') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.show', $user->id) }}">{{ $user->name }}</a></li>
                <li class="breadcrumb-item active">Criar Mensalidade</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Mensalidade</h3>
        </div>

        <form action="{{ route('subscriptions.store', $user->id) }}" class="form" method="POST">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="">Descrição:</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                        placeholder="Digite a descrição" value="{{ 'Mensalidade - ' . \Carbon\Carbon::now()->translatedFormat('F') }}">

                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <div class="col-sm-6">
                        <label for="">Valor total:</label>
                        <input type="number" step=".01" name="total" class="form-control @error('total') is-invalid @enderror"
                            placeholder="Digite o valor total" value="{{ old('total') }}">

                        @error('total')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-sm-6">
                        <label for="">Data de vencimento:</label>
                        <input type="date" name="due_date"
                            class="form-control @error('due_date') is-invalid @enderror"
                            value="{{ old('due_date') }}">

                        @error('due_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
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
