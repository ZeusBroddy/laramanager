@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit User</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Users</a></li>
                <li class="breadcrumb-item active">Edit User</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Account details</h3>
        </div>
        <form action="{{ route('users.update', $user->id) }}" class="form" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label for="">Select user role:</label>
                    <select name="role" class="form-control select2 @error('role') is-invalid @enderror">
                        <option {{ $user->role == 'admin' ? 'selected' : '' }} value="admin">admin</option>
                        <option {{ $user->role == 'user' ? 'selected' : '' }} value="user">user</option>
                    </select>

                    @error('role')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Email:</label>
                    <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                        placeholder="Type email" value="{{ $user->email ?? old('email') }}">

                    @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Full name:</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Type full name" value="{{ $user->name ?? old('name') }}">

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
                            placeholder="Type cpf" value="{{ $user->profile->cpf ?? old('cpf') }}">

                        @error('cpf')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="">Universidade:</label>
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
                <button type="submit" class="btn btn-primary">Edit User</button>
            </div>
        </form>
    </div>
@stop

@section('js')
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
@stop
