<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

class SubscriptionController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'price_id' => ['required', 'string', 'max:255'],
            'token' => ['required', 'string', 'max:255']
        ]);

        /**
         * Faz assinatura atraves do usuario autenticado
         *
         * newSubscription pega da trait do model User, a Billable
         * default -> assinatura padrao
         * Id do preco do produto
         *
         * Token unico criado com JS para validar a transacao de assinatura
         */
        $request->user()
                ->newSubscription('default', $request->price_id)
                ->create($request->token);

        return redirect()->route('dashboard');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        $profile = auth()->user()->profile()->first();
        if ($profile->address == null) {
            return redirect()->route('profile.edit')->with([
                'alert-type' => 'info',
                'message' => 'Para fazer a assinatura, você deve preencher os dados do seu perfil.'
            ]);
        }

        if (auth()->user()->subscribed('default')) {
            return redirect()->route('subscriptions.account');
        }

        $products = StripeController::products();

        return view('subscription.checkout', [
            'products' => $products,
            'intent' => auth()->user()->createSetupIntent(),
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        // Retornar faturas do usuario autenticado
        $invoices = auth()->user()->invoices();

        // Se o usuario autenticado nao tiver assinatura, redireciona para a tela de checkout
        if (!auth()->user()->subscribed('default')) {
            return redirect()->route('subscriptions.checkout');
        }

        return view('subscription.account', compact('invoices'));
    }

    /**
     * https://laravel.com/docs/9.x/billing#generating-invoice-pdfs
     *
     * @return \Illuminate\Http\Response
     */
    public function downloadInvoice($id)
    {
        return auth()->user()
                ->downloadInvoice($id, [
                    'vendor' => config('app.name'),
                    'product' => 'Assinatura VIP'
                ]);
    }
}
