@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.transactions'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.transactions') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.transactions') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Transações</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped display responsive nowrap" width="100%" id="transactions_table">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Tipo</th>
                        <th>Total</th>
                        <th>Pago em</th>
                        <th>Status</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice['name'] }}</td>
                            <td>Cartão de crédito</td>
                            <td>{{ $invoice['total'] }}</td>
                            <td>{{ $invoice['paid_at'] }}</td>
                            <td>
                                <span class="badge {{ $invoice['paid'] == true ? 'bg-success' : 'bg-danger' }}">
                                    {{ $invoice['paid'] == true ? 'Finalizado' : 'Error' }}
                                </span>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" href="{{ $invoice['pdf'] }}" title="Baixar fatura">
                                    <i class="fas fa-file-pdf"></i>
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
@stop

@section('footer')
    @include('admin.components.footer')
@stop

@section('js')
    <script>
        $(function() {
            $("#transactions_table").DataTable({
                scrollY: true,
                scrollX: true,
                "language": {
                    "url": "{{ asset('dataTable/dataTablePortuguese.json') }}"
                }
            });
        });
    </script>
@stop
