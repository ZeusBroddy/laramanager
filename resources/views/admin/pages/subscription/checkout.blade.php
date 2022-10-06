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
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Mensalidade</h3>
        </div>
        <form action="{{ route('subscriptions.store') }}" method="post" id="form">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="">Plano:</label>
                    <select name="price_id" id="price_id" class="form-control select2 @error('price_id') is-invalid @enderror">
                        @foreach ($plans as $plan)
                            <option value="{{ $plan->stripe_plan_id }}">{{ $plan->name }}</option>
                        @endforeach
                    </select>

                    @error('price_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="">Nome no cartão:</label>
                    <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                        placeholder="Jenny Dow" value="{{ $user->name ?? old('name') }}">

                    @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

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
                    <label for="">Cartão:</label>
                    <div id="card-element" class="form-control"></div>
                </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}" type="submit">Enviar</button>
            </div>
        </form>
    </div>
@stop

@section('footer')
    @include('admin.components.footer')
@stop

@section('js')
    <script src="https://js.stripe.com/v3/"></script>
    <script>
        $(function() {
            $('.select2').select2();
        });
    </script>
    <script>
        const stripe = Stripe("{{ config('cashier.key') }}");
        const elements = stripe.elements();
        const cardElement = elements.create('card');
        cardElement.mount('#card-element');

        //subscription_payment
        const form = document.getElementById('form');
        const cardButton = document.getElementById('card-button');
        const clientSecret = cardButton.dataset.secret;

        form.addEventListener('submit', async (e) => {
            e.preventDefault();

            //gerando o token
            const { setupIntent, error } = await stripe.confirmCardSetup(
                clientSecret, {
                    payment_method: {
                        card: cardElement,
                        billing_details: {
                            name: "{{ auth()->user()->name }}"
                        }
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
            token.setAttribute('value', setupIntent.payment_method);
            form.appendChild(token);

            form.submit();
        });
    </script>
@stop
