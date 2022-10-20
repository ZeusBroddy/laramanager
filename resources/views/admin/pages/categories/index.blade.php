@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.categories'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.categories') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.categories') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <!-- .card -->
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Categorias</h3>

            <div class="card-tools">
                <a href="{{ route('categories.create') }}" class="btn btn-tool" title="Novo">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <table class="table table-striped display responsive nowrap" style="width: 100%" id="categories-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($categories as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td class="project-actions text-right">
                                @if (!$category->deleted_at)
                                    <a class="btn btn-default btn-sm" title="Editar"
                                        href="{{ route('categories.edit', $category->id) }}">
                                        <i class="text-info fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-default btn-sm" title="Inativar"
                                        href="{{ route('categories.destroy', $category->id) }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('category-destroy{{ $category->id }}').submit();">
                                        <i class="text-danger fas fa-trash"></i>
                                    </a>
                                    <form action="{{ route('categories.destroy', $category->id) }}" class="d-none"
                                        id="category-destroy{{ $category->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @else
                                    <a class="btn btn-secondary btn-sm" title="Restaurar"
                                        href="{{ route('categories.restore', $category->id) }}">
                                        <i class="fas fa-reply"></i>
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->
@stop

@section('footer')
    @include('admin.components.footer')
@stop

@section('js')
    <script>
        $(function() {
            $("#categories-table").DataTable({
                scrollY: true,
                scrollX: true,
                "language": {
                    "url": "{{ asset('dataTable/dataTablePortuguese.json') }}"
                }
            });
        });
    </script>
@stop
