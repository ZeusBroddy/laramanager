@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Create New University</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('universities.index') }}">Universities</a></li>
                <li class="breadcrumb-item active">Create New University</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title">University details</h3>
    </div>
    <form action="{{ route('universities.store') }}" class="form" enctype="multipart/form-data" method="POST">
        @csrf

        @include('admin.pages.universities._partials.form')

        <div class="card-footer">
            <button type="submit" class="btn btn-primary">Create University</button>
        </div>
    </form>
</div>
@stop
