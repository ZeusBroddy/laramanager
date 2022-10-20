@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.users'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ $user->name }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item"><a href="{{ route('users.index') }}">{{ __('adminlte::menu.users') }}</a></li>
                <li class="breadcrumb-item active">{{ $user->name }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-md-3">

            <!-- Profile Image -->
            <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                    <div class="text-center">
                        <img class="profile-user-img img-fluid img-circle"
                            src="{{ $user->profile->avatar ? asset('storage/' . $user->profile->avatar) : asset('img/profiles/avatar.jpg') }}"
                            alt="User profile picture">
                    </div>

                    <h3 class="profile-username text-center">{{ $user->name }}</h3>

                    <p class="text-muted text-center">{{ $user->email }}</p>

                    <hr>

                    <strong><i class="fas fa-user-shield mr-1"></i> CPF</strong>

                    <p class="text-muted">
                        {{ $user->profile->cpf_formated }}
                    </p>

                    <hr>

                    <strong><i class="fas fa-birthday-cake mr-1"></i> Nascimento</strong>

                    <p class="text-muted">
                        {{ $user->profile->birth_date_formated }}
                    </p>

                    <hr>

                    <strong><i class="fas fa-book mr-1"></i> Faculdade</strong>

                    <p class="text-muted">
                        {{ $user->profile->university->name }}
                    </p>

                    <hr>

                    <strong><i class="fas fa-map-marker-alt mr-1"></i> Endereço</strong>

                    <p class="text-muted">{{ $user->profile->address . ' - ' . $user->profile->city }}</p>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

        </div>
        <!-- /.col -->

        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Mensalidades</h3>

                    <div class="card-tools">
                        <a href="{{ route('subscriptions.create', $user->id) }}" class="btn btn-tool" title="Novo">
                            <i class="fas fa-plus"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-striped display responsive nowrap" style="width: 100%" id="users-table">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Tipo</th>
                                <th>Total</th>
                                <th>Pago em</th>
                                <th>Status</th>
                                <th class="text-right">Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($user->invoices as $invoice)
                                <tr>
                                    <td>Mensalidade: {{ $invoice->due_date_month }}</td>
                                    <td>Cartão</td>
                                    <td>R$ {{ $invoice->total_brl }}</td>
                                    <td>{{ $invoice->paid_at_formated }}</td>
                                    <td>
                                        <span class="badge {{ $invoice->paid_at != null ? 'bg-success' : 'bg-danger' }}">
                                            {{ $invoice->paid_at != null ? 'Finalizado' : 'A pagar' }}
                                        </span>
                                    </td>
                                    <td class="project-actions text-right">
                                        @if ($invoice->paid_at == null)
                                            <a class="btn btn-default btn-sm" href="{{ route('subscriptions.edit', $invoice->id) }}"
                                                title="Editar">
                                                <i class="text-info fas fa-pencil-alt"></i>
                                            </a>
                                            <a class="btn btn-default btn-sm"
                                                href="{{ route('subscriptions.destroy', $invoice->id) }}" title="Remover"
                                                onclick="event.preventDefault();
                                            document.getElementById('user-destroy{{ $invoice->id }}').submit();">
                                                <i class="text-danger fas fa-trash"></i>
                                            </a>
                                            <form action="{{ route('subscriptions.destroy', $invoice->id) }}" class="d-none"
                                                id="user-destroy{{ $invoice->id }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        @else
                                            <a class="btn btn-default btn-sm" title="Baixar fatura"
                                                href="{{ route('subscriptions.invoice.download', $invoice->id) }}">
                                                <i class="text-gray-dark fas fa-file-pdf"></i>
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
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->
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
