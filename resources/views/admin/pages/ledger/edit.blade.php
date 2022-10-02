@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Edit Expense</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">Expenses</a></li>
                <li class="breadcrumb-item active">Edit Expense</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Account details</h3>
        </div>
        <form action="{{ route('ledger.update', $entry->id) }}" class="form" method="POST">
            @csrf
            @method('PUT')

            <div class="card-body">
                <div class="form-group">
                    <label for="">Select expense type:</label>
                    <select name="type" class="form-control select2 @error('type') is-invalid @enderror">
                        <option value="income">income</option>
                        <option value="expense" {{ $entry->type == 'expense' ? 'selected' : '' }}>expense</option>
                    </select>

                    @error('type')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Category:</label>
                    <select name="category_id" class="form-control select2 @error('category_id') is-invalid @enderror">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ $entry->category_id == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('category_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Description:</label>
                    <input type="text" name="description" class="form-control @error('description') is-invalid @enderror"
                        placeholder="Type description" value="{{ $entry->description ?? old('description') }}">

                    @error('description')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group row">
                    <div class="col-6">
                        <label for="">Amount:</label>
                        <input type="number" name="amount" class="form-control @error('amount') is-invalid @enderror"
                            placeholder="Type amount" value="{{ $entry->amount ?? old('amount') }}">

                        @error('amount')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="col-6">
                        <label for="">Date:</label>
                        <input type="date" name="date" class="form-control @error('date') is-invalid @enderror"
                            placeholder="Confirm password" value="{{ $entry->date ?? old('date') }}">

                        @error('date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

            </div>

            <div class="card-footer">
                <button type="submit" class="btn btn-primary">Edit Entry</button>
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
