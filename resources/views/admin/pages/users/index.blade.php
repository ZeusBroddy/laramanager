@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.users'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.users') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.users') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Usuários</h3>

            <div class="card-tools">
                <a href="{{ route('users.create') }}" class="btn btn-tool" title="Novo">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-responsive-md table-striped" id="users-table">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>E-mail</th>
                        <th>Papel</th>
                        <th>CPF</th>
                        <th>Criado em</th>
                        <th>Assinatura</th>
                        <th>Faculdade</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <img src="{{ $user->profile->avatar ? asset('storage/' . $user->profile->avatar) : asset('img/profiles/avatar.png') }}"
                                    alt="avatar" class="img-circle img-size-32 mr-2">
                                {{ $user->name }}
                            </td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge {{ $user->role == 'user' ? 'bg-primary' : 'bg-purple' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>{{ $user->profile->cpf_formated }}</td>
                            <td>{{ $user->created_at_formated }}</td>
                            <td>
                                <span class="badge {{ $user->subscribed('default') ? 'bg-success' : 'bg-gray' }}">
                                    {{ $user->subscribed('default') ? 'Ativo' : 'Inativo' }}
                                </span>
                            </td>
                            <td>{{ $user->profile->university->name }}</td>
                            <td class="project-actions text-right">
                                @if (!$user->deleted_at)
                                    <a class="btn btn-info btn-sm" href="{{ route('users.edit', $user->id) }}" title="Editar">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-danger btn-sm" href="{{ route('users.destroy', $user->id) }}" title="Remover"
                                        onclick="event.preventDefault();
                                        document.getElementById('user-destroy{{ $user->id }}').submit();">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" class="d-none"
                                        id="user-destroy{{ $user->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @else
                                    <a class="btn btn-secondary btn-sm" href="{{ route('users.restore', $user->id) }}" title="Restaurar">
                                        <i class="fas fa-reply"></i>
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
@stop

@section('footer')
    @include('admin.components.footer')
@stop

@section('js')
    <script>
        $(function() {
            $("#users-table").DataTable({
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
