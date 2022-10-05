@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>All Universities</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">All Universities</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Universities</h3>

            <div class="card-tools">
                <a href="{{ route('universities.create') }}" class="btn btn-tool">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-md table-striped" id="universities-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>District</th>
                        <th>City</th>
                        <th>Path</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($universities as $university)
                        <tr>
                            <td>
                                <img src="{{ $university->avatar ? asset('storage/' . $university->avatar) : asset('img/avatar.png') }}"
                                    alt="avatar"
                                    class="img-circle img-size-32 mr-2">
                                {{ $university->name }}
                            </td>
                            <td>{{ $university->address }}</td>
                            <td>{{ $university->district }}</td>
                            <td>{{ $university->city }}</td>
                            <td>{{ $university->path->name }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('universities.edit', $university->id) }}">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="{{ route('universities.destroy', $university->id) }}"
                                    onclick="event.preventDefault();
                                        document.getElementById('university-destroy{{ $university->id }}').submit();">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <form action="{{ route('universities.destroy', $university->id) }}" class="d-none"
                                    id="university-destroy{{ $university->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                </form>
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

@section('js')
    <script>
        $(function() {
            $("#universities-table").DataTable({
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
