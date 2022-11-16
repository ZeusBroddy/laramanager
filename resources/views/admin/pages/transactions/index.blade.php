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
            <table class="table table-striped display responsive nowrap" style="width: 100%" id="transactions_table">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Descrição</th>
                        <th>Tipo</th>
                        <th>Total</th>
                        <th>Pago em</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->user->name }}</td>
                            <td>{{ $invoice->description }}</td>
                            <td>Cartão</td>
                            <td>R$ {{ $invoice->total_brl }}</td>
                            <td>{{ $invoice->paid_at_formated }}</td>
                            <td>
                                <span class="badge {{ $invoice->paid_at != null ? 'bg-success' : 'bg-danger' }}">
                                    {{ $invoice->paid_at != null ? 'Finalizado' : 'A pagar' }}
                                </span>
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
