@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Profile Settings</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Profile Settings</li>
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
                            src="{{ $user->profile->avatar ?? asset('img/avatar5.png') }}" alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ $user->email }}</p>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="col-md-9">
            <form action="{{ route('profile.update') }}" class="form" method="POST">
                @csrf
                @method('PUT')

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Billing Information</h3>
                    </div>

                    <div class="card-body">

                        <div class="form-group">
                            <label for="">Address:</label>
                            <input type="text" name="address" class="form-control @error('address') is-invalid @enderror"
                                value="{{ $user->profile->address ?? old('address') }}">

                            @error('address')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="">City:</label>
                                <input type="text" name="city"
                                    class="form-control @error('city') is-invalid @enderror"
                                    value="{{ $user->profile->city ?? old('city') }}">

                                @error('city')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="">Postal Code:</label>
                                <input type="text" name="postal_code"
                                    class="form-control @error('postal_code') is-invalid @enderror"
                                    value="{{ $user->profile->postal_code ?? old('postal_code') }}">

                                @error('postal_code')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="">Country:</label>
                                <input type="text" name="country"
                                    class="form-control @error('country') is-invalid @enderror"
                                    value="{{ $user->profile->country ?? old('country') }}">

                                @error('country')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="col-6">
                                <label for="">State:</label>
                                <input type="text" name="state"
                                    class="form-control @error('state') is-invalid @enderror"
                                    value="{{ $user->profile->state ?? old('state') }}">

                                @error('state')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">Phone Number:</label>
                            <input type="text" name="phone_number"
                                class="form-control @error('phone_number') is-invalid @enderror"
                                value="{{ $user->profile->phone_number ?? old('phone_number') }}">

                            @error('phone_number')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div>

        {{-- <div class="col-md-12">
            <form action="{{ route('profile.update') }}" class="form" method="POST">
                @csrf
                @method('PUT')

                <div class="card card-primary">
                    <div class="card-header">
                        <h3 class="card-title">Billing Information</h3>
                    </div>
                    <div class="card-body">

                        <div class="form-group">
                            <label for="">Address:</label>
                            <input type="text" name="address" class="form-control"
                                value="{{ $user->profile->address ?? old('address') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Country:</label>
                            <input type="text" name="country" class="form-control"
                                value="{{ $user->profile->country ?? old('country') }}">
                        </div>

                        <div class="form-group row">
                            <div class="col-6">
                                <label for="">City:</label>
                                <input type="text" name="city" class="form-control"
                                    value="{{ $user->profile->city ?? old('city') }}">
                            </div>

                            <div class="col-6">
                                <label for="">Postal Code:</label>
                                <input type="text" name="postal_code" class="form-control"
                                    value="{{ $user->profile->postal_code ?? old('postal_code') }}">
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="">State:</label>
                            <input type="text" name="state" class="form-control"
                                value="{{ $user->profile->state ?? old('state') }}">
                        </div>

                        <div class="form-group">
                            <label for="">Phone Number:</label>
                            <input type="text" name="phone_number" class="form-control"
                                value="{{ $user->profile->phone_number ?? old('phone_number') }}">
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </div>
                </div>
            </form>
        </div> --}}
    </div>
@stop
