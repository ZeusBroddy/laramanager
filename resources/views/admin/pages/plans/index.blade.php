@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>All Plans</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">All Plans</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Plans</h3>

            <div class="card-tools">
                <a href="{{ route('plans.create') }}" class="btn btn-tool">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-md table-striped" id="plans-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Stripe Plan ID</th>
                        <th>Stripe Product ID</th>
                        <th>Amount</th>
                        <th>Interval</th>
                        <th>Status</th>
                        <th class="text-right">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($plans as $plan)
                        <tr>
                            <td>{{ $plan->name }}</td>
                            <td>{{ $plan->stripe_plan_id }}</td>
                            <td>{{ $plan->stripe_product_id }}</td>
                            <td>R$ {{ $plan->amount_brl }}</td>
                            <td>{{ $plan->interval }}</td>
                            <td>
                                <span class="badge {{ $plan->status == 'active' ? 'bg-success' : 'bg-red' }}">
                                    {{ $plan->status }}
                                </span>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-danger btn-sm" href="{{ route('plans.destroy', $plan->id) }}"
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
