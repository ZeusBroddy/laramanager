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
            <table class="table table-responsive-md table-striped" id="categories-table">
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
                                    <a class="btn btn-info btn-sm" title="Editar"
                                        href="{{ route('categories.edit', $category->id) }}">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm" title="Inativar"
                                        href="{{ route('categories.destroy', $category->id) }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('category-destroy{{ $category->id }}').submit();">
                                        <i class="fas fa-trash"></i>
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
                "language": {
                    "sProcessing": "Processando...",
                    "sLengthMenu": "Mostrar _MENU_ registros",
                    "sZeroRecords": "Nenhum resultado encontrado",
                    "sEmptyTable": "Nenhum dado disponível nesta tabela",
                    "sInfo": "Mostrando registros de _START_ a _END_ de um total de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando registros de 0 a 0 de um total de 0 registros",
                    "sInfoFiltered": "(filtrado de um total de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sSearch": "Pesquisar:",
                    "sUrl": "",
                    "sInfoThousands": ",",
                    "sLoadingRecords": "Carregando...",
                    "oPaginate": {
                        "sFirst": "Primeiro",
                        "sLast": "Último",
                        "sNext": "Seguinte",
                        "sPrevious": "Anterior"
                    },
                    "oAria": {
                        "sSortAscending": ": Ativar para ordenar a coluna de maneira ascendente",
                        "sSortDescending": ": Ativar para ordenar a coluna de maneira descendente"
                    }
                }
            });
        });
    </script>
@stop
