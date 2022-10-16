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
    <div class="row">
        <div class="col-md-3">

            <div class="card card-primary card-outline">
                <div class="card-body box-profile">

                    <h3 class="profile-username text-center">Mensalidade: {{ $invoice->due_date_month }}</h3>

                    <p class="text-xl text-center">R$ {{ $invoice->total }}</p>
                </div>
                <!-- /.card-body -->
            </div>
        </div>

        <div class="col-md-9">
            <div class="card card-primary card-outline">
                <div class="card-header">
                    <h3 class="card-title">Informações de Pagamento</h3>
                </div>

                <form action="{{ route('subscriptions.update', $invoice->id) }}" class="form" method="POST" id="form">
                    @csrf
                    @method('PUT')

                    <div class="card-body">
                        <div class="form-group">
                            <label for="">E-mail:</label>
                            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                placeholder="jennydow@email.com" value="{{ $user->email ?? old('email') }}" disabled>

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Nome no cartão:</label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                                id="card-holder-name" placeholder="Jenny Dow" value="{{ $user->name ?? old('name') }}">

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label for="">Dados do cartão:</label>
                            <div id="card-element" class="form-control"></div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <button class="btn btn-primary" id="card-button" type="submit">Enviar</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@stop

@section('footer')
    @include('admin.components.footer')
@stop

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        const stripe = Stripe("{{ config('cashier.key') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        //subscription_payment
        const form = document.getElementById('form');
        const cardHolderName = document.getElementById('card-holder-name');
        const cardButton = document.getElementById('card-button');

        cardButton.addEventListener('click', async (e) => {
            e.preventDefault();

            //gerando o token
            const {
                paymentMethod,
                error
            } = await stripe.createPaymentMethod(
                'card', cardElement, {
                    billing_details: {
                        name: cardHolderName.value
                    }
                }
            );

            if (error) {
                toastr.error(error.message);
                return;
            }

            let token = document.createElement('input');
            token.setAttribute('type', 'hidden');
            token.setAttribute('name', 'token');
            token.setAttribute('value', paymentMethod.id);
            form.appendChild(token);

            form.submit();
        });
    </script>
@stop
