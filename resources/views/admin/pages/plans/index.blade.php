@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.plans'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.plans') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.plans') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Planos</h3>

            <div class="card-tools">
                <a href="{{ route('plans.create') }}" class="btn btn-tool" title="Novo">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-md table-striped" id="plans-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Status</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $plan)
                        <tr>
                            <td>{{ $plan->name }}</td>
                            <td>{{ $plan->description }}</td>
                            <td>{{ $plan->amount_brl }}</td>
                            <td>
                                <span class="badge {{ $plan->status == 'active' ? 'bg-success' : 'bg-red' }}">
                                    {{ $plan->status == 'active' ? 'ativo' : 'inativo' }}
                                </span>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ route('plans.edit', $plan->id) }}"
                                    title="Editar">
                                    <i class="fas fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-danger btn-sm" href="{{ route('plans.destroy', $plan->id) }}"
                                    title="Remover"
                                    onclick="event.preventDefault();
                                    document.getElementById('plan-destroy{{ $plan->id }}').submit();">
                                    <i class="fas fa-trash"></i>
                                </a>
                                <form action="{{ route('plans.destroy', $plan->id) }}" class="d-none"
                                    id="plan-destroy{{ $plan->id }}" method="POST">
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
            $("#plans-table").DataTable({
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
