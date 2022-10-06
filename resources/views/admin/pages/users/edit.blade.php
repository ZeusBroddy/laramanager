@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.users'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Editar Usuário</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('adminlte::menu.users') }}</a></li>
                <li class="breadcrumb-item active">Editar Usuário</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Usuário</h3>
        </div>
        <form action="{{ route('users.update', $user->id) }}" class="form" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label for="">Papel:</label>
                    <select name="role" class="form-control select2 @error('role') is-invalid @enderror">
                        <option value="admin">Admin</option>
                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                    </select>

                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">E-mail:</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="unkown@email.com" value="{{ $user->email ?? old('email') }}">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Nome completo:</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Jenny Dow" value="{{ $user->name ?? old('name') }}">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <div class="col-6">
                        <label for="">CPF:</label>
                        <input type="text" name="cpf" class="form-control @error('cpf') is-invalid @enderror"
                            placeholder="00000000000" value="{{ $user->profile->cpf ?? old('cpf') }}">

                        @error('cpf')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="">Faculdade:</label>
                        <select name="university_id"
                            class="form-control select2 @error('university_id') is-invalid @enderror">
                            @foreach ($universities as $university)
                                <option value="{{ $university->id }}"
                                    @isset($user)
                                        {{ $user->profile->university_id == $university->id ? 'selected' : '' }}
                                    @endisset>
                                    {{ $university->name }}
                                </option>
                            @endforeach
                        </select>

                        @error('university_id')
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

@section('js')
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
@stop
