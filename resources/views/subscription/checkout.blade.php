@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <div class="row mb-2">
        <div class="col-sm-6">
            <h1>Subscription</h1>
        </div>
        <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Subscription</li>
            </ol>
        </div>
    </div>
@stop

@section('content')
    <div class="card card-primary">
        <div class="card-header">
            <h3 class="card-title">Account details</h3>
        </div>
        <form action="{{ route('subscriptions.store') }}" method="post" id="form">
            @csrf

            <div class="card-body">
                <div class="form-group">
                    <label for="">Select plan:</label>
                    <select name="price_id" id="price_id" class="form-control select2 @error('price_id') is-invalid @enderror">
                        @foreach ($products as $plan)
                            <option value="{{ $plan['price_details']['id'] }}">{{ $plan['name'] }}</option>
                        @endforeach
                    </select>

                    @error('price_id')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>

                <div class="form-group">
                    <div id="card-element" class="form-control"></div>
                </div>

            </div>

            <div class="card-footer">
                <button class="btn btn-primary" id="card-button" data-secret="{{ $intent->client_secret }}" type="submit">Enviar</button>
            </div>
        </form>
    </div>
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
