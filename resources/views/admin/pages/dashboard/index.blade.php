@extends('adminlte::page')

@section('title', __('adminlte::menu.dashboard'))

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>{{ __('adminlte::menu.dashboard') }}</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item active">{{ __('adminlte::menu.dashboard') }}</li>
            </ol>
        </div>
    </div>
@stop

@section('content')

    <!-- Info boxes -->
    <div class="row">
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-success elevation-1"><i class="fas fa-shopping-cart"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Receitas</span>
                    <span class="info-box-number">R$ {{ $incomes }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Despesas</span>
                    <span class="info-box-number">R$ {{ $expenses }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix hidden-md-up"></div>

        <div class="col-12 col-sm-6 col-md-3">
            <!-- /.info-box -->
            <div class="info-box">
                <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Caixa</span>
                    <span class="info-box-number">
                        R$ {{ $balance }}
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-12 col-sm-6 col-md-3">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-primary elevation-1"><i class="fas fa-users"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Usuários</span>
                    <span class="info-box-number">{{ $usersCount }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
        <!-- Left col -->
        <div class="col-md-8">
            <!-- Custom tabs (Charts with tabs)-->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        <i class="fas fa-chart-pie mr-1"></i>
                        Financeiro
                    </h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content p-0">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" style="position: relative; height: 300px;">
                            <canvas id="revenue-chart-canvas" height="300" style="height: 300px;"></canvas>
                        </div>
                    </div>
                </div><!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- TABLE: LATEST TRANSACTIONS -->
            @if (count($invoices) > 0)
                <div class="card">
                    <div class="card-header border-transparent">
                        <h3 class="card-title">Últimas transações</h3>

                        <div class="card-tools">
                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                <i class="fas fa-minus"></i>
                            </button>
                            <button type="button" class="btn btn-tool" data-card-widget="remove">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table m-0 table-hover">
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
                                            <td>Mensalidade: {{ $invoice->due_date_month }}</td>
                                            <td>Cartão</td>
                                            <td>R$ {{ $invoice->total_brl }}</td>
                                            <td>{{ $invoice->paid_at_formated }}</td>
                                            <td>
                                                <span
                                                    class="badge {{ $invoice->paid_at != null ? 'bg-success' : 'bg-danger' }}">
                                                    {{ $invoice->paid_at != null ? 'Finalizado' : 'A pagar' }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            @endif
        </div>
        <!-- /.col -->


        <!-- Right col -->
        <div class="col-md-4">

            <!-- USERS LIST -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Novos Membros</h3>

                    <div class="card-tools">
                        <span class="badge badge-danger">{{ $latestEithUsers->count() }} Novos Membros</span>
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0">
                    <ul class="users-list clearfix">
                        @foreach ($latestEithUsers as $user)
                            <li>
                                <img src="{{ $user->profile->avatar ? asset('storage/' . $user->profile->avatar) : asset('img/profiles/avatar.jpg') }}"
                                    class="" alt="User Image">
                                <a class="users-list-name" href="#">{{ $user->name }}</a>
                                <span class="users-list-date">{{ $user->created_at_formated }}</span>
                            </li>
                        @endforeach
                    </ul>
                    <!-- /.users-list -->
                </div>
                <!-- /.card-body -->
                {{-- <div class="card-footer text-center">
                    <a href="javascript:">View All Users</a>
                </div> --}}
                <!-- /.card-footer -->
            </div>
            <!--/.card -->

            <!-- DONUT CHART -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Associados por faculdade</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="universitiesPerUsers"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                </div>
                <!-- /.card-body -->
            </div>
            <!-- /.card -->

            <!-- DONUT CHART -->
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Associados por rota</h3>

                    <div class="card-tools">
                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                            <i class="fas fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-tool" data-card-widget="remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="routesPerUsers"
                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
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
            var donutChartCanvas = $('#universitiesPerUsers').get(0).getContext('2d')
            var donutData = {
                labels: [
                    @foreach ($universities as $university)
                        @if ($university->profiles_count == 0)
                            @continue
                        @endif
                        ["{{ $university->name }}"],
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach ($universities as $university)
                            @if ($university->profiles_count == 0)
                                @continue
                            @endif
                            [{{ $university->profiles_count }}],
                        @endforeach
                    ],
                    backgroundColor: ['#f56954', '#00a65a', '#f39c12', '#00c0ef', '#3c8dbc', '#d2d6de'],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }

            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })

            var donutChartCanvas = $('#routesPerUsers').get(0).getContext('2d')
            var donutData = {
                labels: [
                    @foreach ($paths as $path)
                        ["{{ $path->name }}"],
                    @endforeach
                ],
                datasets: [{
                    data: [
                        @foreach ($paths as $path)
                            ["{{ $path->profiles_count }}"],
                        @endforeach
                    ],
                    backgroundColor: ['#00c0ef', '#00a65a', '#d2d6de', '#3c8dbc', '#f56954', '#f39c12'],
                }]
            }
            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }

            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })


            /* Chart.js Charts */
            // Sales chart
            var salesChartCanvas = document.getElementById('revenue-chart-canvas').getContext('2d')
            // $('#revenue-chart').get(0).getContext('2d');

            var salesChartData = {
                labels: ['Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro'],
                datasets: [{
                        label: 'Digital Goods',
                        backgroundColor: 'rgba(60,141,188,0.9)',
                        borderColor: 'rgba(60,141,188,0.8)',
                        pointRadius: false,
                        pointColor: '#3b8bba',
                        pointStrokeColor: 'rgba(60,141,188,1)',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(60,141,188,1)',
                        data: [28, 48, 40, 19, 86, 27, 90]
                    },
                    {
                        label: 'Electronics',
                        backgroundColor: 'rgba(210, 214, 222, 1)',
                        borderColor: 'rgba(210, 214, 222, 1)',
                        pointRadius: false,
                        pointColor: 'rgba(210, 214, 222, 1)',
                        pointStrokeColor: '#c1c7d1',
                        pointHighlightFill: '#fff',
                        pointHighlightStroke: 'rgba(220,220,220,1)',
                        data: [65, 59, 80, 81, 56, 55, 40]
                    }
                ]
            }

            var salesChartOptions = {
                maintainAspectRatio: false,
                responsive: true,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }

            // This will get the first returned node in the jQuery collection.
            // eslint-disable-next-line no-unused-vars
            var salesChart = new Chart(salesChartCanvas, { // lgtm[js/unused-local-variable]
                type: 'line',
                data: salesChartData,
                options: salesChartOptions
            })
        })
    </script>
@stop
