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
            <table class="table table-striped display responsive nowrap" style="width: 100%" id="plans-table">
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
                                <a class="btn btn-default btn-sm" href="{{ route('plans.edit', $plan->id) }}"
                                    title="Editar">
                                    <i class="text-info fas fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-default btn-sm" title="Inativar" data-toggle="modal" id="smallButton"
                                    data-target="#smallModal" data-attr="{{ route('plans.delete', $plan->id) }}">
                                    <i class="text-danger fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
    <!-- /.card -->

    @include('admin.components.modal')
@stop

@section('footer')
    @include('admin.components.footer')
@stop

@section('js')
    <script>
        $(function() {
            $("#plans-table").DataTable({
                scrollY: true,
                scrollX: true,
                "language": {
                    "url": "{{ asset('dataTable/dataTablePortuguese.json') }}"
                }
            });
        });
    </script>

    <script src="{{ asset('js/modal.js') }}"></script>
@stop
