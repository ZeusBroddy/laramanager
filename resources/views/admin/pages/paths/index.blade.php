@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.paths'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.paths') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.paths') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Rotas</h3>

            <div class="card-tools">
                <a href="{{ route('paths.create') }}" class="btn btn-tool" title="Novo">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped display responsive nowrap" width="100%" id="paths-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paths as $path)
                        <tr>
                            <td>{{ $path->name }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-default btn-sm" href="{{ route('paths.edit', $path->id) }}" title="Editar">
                                    <i class="text-info fas fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-default btn-sm" href="{{ route('paths.destroy', $path->id) }}" title="Remover"
                                    onclick="event.preventDefault();
                                        document.getElementById('paht-destroy{{ $path->id }}').submit();">
                                    <i class="text-danger fas fa-trash"></i>
                                </a>
                                <form action="{{ route('paths.destroy', $path->id) }}" class="d-none"
                                    id="paht-destroy{{ $path->id }}" method="POST">
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

@section('footer')
    @include('admin.components.footer')
@stop

@section('js')
    <script>
        $(function() {
            $("#paths-table").DataTable({
                scrollY: true,
                scrollX: true,
                "language": {
                    "url": "{{ asset('dataTable/dataTablePortuguese.json') }}"
                }
            });
        });
    </script>
@stop
