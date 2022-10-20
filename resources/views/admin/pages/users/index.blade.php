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
            <table class="table table-striped display responsive nowrap" style="width: 100%" id="users-table">
                <thead>
                    <tr>
                        <th>Usuário</th>
                        <th>Papel</th>
                        <th>CPF</th>
                        <th>Nascimento</th>
                        <th>Faculdade</th>
                        <th>Débito?</th>
                        <th>Criado em</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>
                                <div class="user-block">
                                    <img src="{{ $user->profile->avatar ? asset('storage/' . $user->profile->avatar) : asset('img/profiles/avatar.png') }}"
                                        alt="avatar" class="img-circle img-size-32 mr-2">
                                    <span class="username">{{ $user->name }}</span>
                                    <span class="description">{{ $user->email }}</span>
                                </div>
                            </td>
                            <td>
                                <span class="badge {{ $user->role == 'user' ? 'bg-primary' : 'bg-purple' }}">
                                    {{ $user->role }}
                                </span>
                            </td>
                            <td>{{ $user->profile->cpf_formated }}</td>
                            <td>{{ $user->profile->birth_date_formated }}</td>
                            <td>{{ $user->profile->university->name }}</td>
                            <td>
                                <span class="badge {{ $user->invoices_count > 0 ? 'bg-danger' : 'bg-success' }}">
                                    {{ $user->invoices_count > 0 ? 'Sim' : 'Não' }}
                                </span>
                            </td>
                            <td>{{ $user->created_at_formated }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-default btn-sm" href="{{ route('users.show', $user->id) }}"
                                    title="Visualizar">
                                    <i class="text-primary fas fa-eye"></i>
                                </a>
                                @if (!$user->deleted_at)
                                    <a class="btn btn-default btn-sm" href="{{ route('users.edit', $user->id) }}"
                                        title="Editar">
                                        <i class="text-info fas fa-pencil-alt"></i>
                                    </a>
                                    <a class="btn btn-default btn-sm" href="{{ route('users.destroy', $user->id) }}"
                                        title="Remover"
                                        onclick="event.preventDefault();
                                        document.getElementById('user-destroy{{ $user->id }}').submit();">
                                        <i class="text-danger fas fa-trash"></i>
                                    </a>
                                    <form action="{{ route('users.destroy', $user->id) }}" class="d-none"
                                        id="user-destroy{{ $user->id }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                @else
                                    <a class="btn btn-default btn-sm" href="{{ route('users.restore', $user->id) }}"
                                        title="Restaurar">
                                        <i class="text-secondary fas fa-reply"></i>
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
                scrollY: true,
                scrollX: true,
                "language": {
                    "url": "{{ asset('dataTable/dataTablePortuguese.json') }}"
                }
            });
        });
    </script>
@stop
