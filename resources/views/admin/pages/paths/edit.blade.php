@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Path</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('paths.index') }}">Path</a></li>
                <li class="breadcrumb-item active">Edit Path</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Path details</h3>
    </div>
    <form action="{{ route('paths.update', $path->id) }}" class="form" method="POST">
        @csrf
        @method('PUT')

        @include('admin.pages.paths._partials.form')

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Edit Path</button>
        </div>
    </form>
</div>
@stop
