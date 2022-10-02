@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create New Plan</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('plans.index') }}">Plans</a></li>
                <li class="breadcrumb-item active">Create New Plan</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Plan details</h3>
    </div>
    <form action="{{ route('plans.store') }}" class="form" method="POST">
        @csrf

        <div class="card-body">

            <div class="form-group">
                <label for="">Plan name:</label>
                <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                    placeholder="Type plan name" value="{{ old('name') }}">

                @error('name')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Interval:</label>
                <input type="text" name="interval" class="form-control @error('interval') is-invalid @enderror"
                    placeholder="Type recurring interval" value="{{ old('interval') }}">

                @error('interval')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

            <div class="form-group">
                <label for="">Amount:</label>
                <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                    placeholder="Type amount" value="{{ old('amount') }}">

                @error('amount')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>

        </div>

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create Plan</button>
        </div>
    </form>
</div>
@stop
