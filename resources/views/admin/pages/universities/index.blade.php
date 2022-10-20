@extends('adminlte::page')

@section('title', config('app.name') . ' - ' . __('adminlte::menu.universities'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.universities') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('adminlte::menu.dashboard') }}</a></li>
                <li class="breadcrumb-item active">{{ __('adminlte::menu.universities') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Faculdades</h3>

            <div class="card-tools">
                <a href="{{ route('universities.create') }}" class="btn btn-tool" title="Novo">
                    <i class="fas fa-plus"></i>
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-striped display responsive nowrap" style="width: 100%" id="universities-table">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>Endereço</th>
                        <th>Bairro</th>
                        <th>Cidade</th>
                        <th>Rota</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($universities as $university)
                        <tr>
                            <td>
                                <img src="{{ $university->avatar ? asset('storage/' . $university->avatar) : asset('img/avatar.png') }}"
                                    alt="avatar" class="img-circle img-size-32 mr-2">
                                {{ $university->name }}
                            </td>
                            <td>{{ $university->address }}</td>
                            <td>{{ $university->district }}</td>
                            <td>{{ $university->city }}</td>
                            <td>{{ $university->path->name }}</td>
                            <td class="project-actions text-right">
                                <a class="btn btn-default btn-sm" href="{{ route('universities.edit', $university->id) }}"
                                    title="Editar">
                                    <i class="text-info fas fa-pencil-alt"></i>
                                </a>
                                <a class="btn btn-default btn-sm"
                                    href="{{ route('universities.destroy', $university->id) }}" title="Remover"
                                    onclick="event.preventDefault();
                                        document.getElementById('university-destroy{{ $university->id }}').submit();">
                                    <i class="text-danger fas fa-trash"></i>
                                </a>
                                <form action="{{ route('universities.destroy', $university->id) }}" class="d-none"
                                    id="university-destroy{{ $university->id }}" method="POST">
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
            $("#universities-table").DataTable({
                scrollY: true,
                scrollX: true,
                "language": {
                    "url": "{{ asset('dataTable/dataTablePortuguese.json') }}"
                }
            });
        });
    </script>
@stop
