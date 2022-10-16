@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.ledger'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.ledger') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.ledger') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Financeiro</h3>

            <div class="card-tools">
                <a href="{{ route('ledger.create') }}" class="btn btn-tool" title="Novo">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped display responsive nowrap" width="100%" id="users-table">
                <thead>
                    <tr>
                        <th>Categoria</th>
                        <th>Tipo</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Data</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ledgers as $entry)
                        <tr>
                            <td>{{ $entry->category->name }}</td>
                            <td>
                                <span class="badge {{ $entry->type == 'income' ? 'bg-success' : 'bg-red' }}">
                                    {{ $entry->type == 'income' ? 'receita' : 'despesa' }}
                                </span>
                            </td>
                            <td>{{ $entry->description }}</td>
                            <td>{{ $entry->amount }}</td>
                            <td>{{ $entry->date_formated }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-default btn-sm" href="{{ route('ledger.edit', $entry->id) }}"
                                    title="Editar"><i class="text-info fas fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-default btn-sm" href="{{ route('ledger.destroy', $entry->id) }}"
                                    title="Remover"
                                    onclick="event.preventDefault();
                                    document.getElementById('entry-destroy{{ $entry->id }}').submit();">
                                    <i class="text-danger fas fa-trash"></i>
                                </a>
                                <form action="{{ route('ledger.destroy', $entry->id) }}" class="d-none"
                                    id="entry-destroy{{ $entry->id }}" method="POST">
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
            $("#users-table").DataTable({
                scrollY: true,
                scrollX: true,
                "language": {
                    "url": "{{ asset('dataTable/dataTablePortuguese.json') }}"
                }
            });
        });
    </script>
@stop
