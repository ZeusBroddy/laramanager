@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Category</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></li>
                <li class="breadcrumb-item active">Edit Category</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">Category details</h3>
    </div>
    <form action="{{ route('categories.update') }}" class="form" method="POST">
        @csrf

        @include('admin.pages.categories._partials.form')

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Edit Category</button>
        </div>
    </form>
</div>
@stop
