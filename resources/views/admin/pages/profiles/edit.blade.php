@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.profile'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.profile') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.profile') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ $user->profile->avatar ? asset('storage/' . $user->profile->avatar) : asset('img/profiles/avatar.jpg') }}"
                            alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ $user->email }}</p>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="col-md-9">
            <form action="{{ route('profile.update') }}" class="form" enctype="multipart/form-data" method="POST">
                @csrf
                @method('PUT')

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Informações</h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="">Endereço:</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                placeholder="Av São Paulo, 4121" value="{{ $user->profile->address ?? old('address') }}">

                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-sm-6">
                                <label for="">Cidade:</label>
                                <input type="text" name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    placeholder="Ministro Andreazza" value="{{ $user->profile->city ?? old('city') }}">

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-sm-6">
                                <label for="">CEP:</label>
                                <input type="text" name="postal_code"
                                    class="form-control @error('postal_code') is-invalid @enderror"
                                    placeholder="76919000" value="{{ $user->profile->postal_code ?? old('postal_code') }}">

                                @error('postal_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Telefone:</label>
                            <input type="text" name="phone_number"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                placeholder="69911111111" value="{{ $user->profile->phone_number ?? old('phone_number') }}">

                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="exampleInputFile">Foto:</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('avatar') is-invalid @enderror"
                                        id="exampleInputFile" name="avatar">
                                    <label class="custom-file-label" for="exampleInputFile">Selecionar Arquivo</label>
                                </div>
                            </div>
                            @error('avatar')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Salvar</button>
                    </div>
                </div>
            </form>
        </div>

    </div>
@stop

@section('footer')
    @include('admin.components.footer')
@stop

@section('js')
    <script>
        $(function() {
            bsCustomFileInput.init();
        });
    </script>
@stop
