@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.subscription'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.subscription') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.subscription') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Mensalidade</h3>
        </div>

        <div class="card-body">
            <table class="table table-striped display responsive nowrap" width="100%" id="subscription_table">
                <thead>
                    <tr>
                        <th>Tipo de cobrança</th>
                        <th>Descrição</th>
                        <th>Valor</th>
                        <th>Pago Em</th>
                        <th>Status</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoices as $invoice)
                        <tr>
                            <td>Mensalidade: {{ $invoice->due_date_month }}</td>
                            <td>{{ $invoice->description }}</td>
                            <td>R$ {{ $invoice->total_brl }}</td>
                            <td>{{ $invoice->paid_at_formated }}</td>
                            <td>
                                <span class="badge {{ $invoice->paid_at != null ? 'bg-success' : 'bg-danger' }}">
                                    {{ $invoice->paid_at != null ? 'Finalizado' : 'A pagar' }}
                                </span>
                            </td>
                            <td class="project-actions text-right">
                                <a class="btn btn-info btn-sm" title="Baixar fatura"
                                    href="{{ route('subscriptions.invoice.download', $invoice->id) }}">
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
            $("#subscription_table").DataTable({
                scrollY: true,
                scrollX: true,
                "language": {
                    "url": "{{ asset('dataTable/dataTablePortuguese.json') }}"
                }
            });
        });
    </script>
@stop
