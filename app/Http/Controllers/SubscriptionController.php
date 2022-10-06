<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Laravel\Cashier\Cashier;

use function PHPUnit\Framework\isNull;

class SubscriptionController extends Controller
{
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

        return redirect()->route('dashboard')->with([
            'alert-type' => 'success',
            'message' => 'Assinatura criada com sucesso!'
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout()
    {
        $user = auth()->user();
        if ($user->profile->address == null) {
            return redirect()->route('profile.edit')->with([
                'alert-type' => 'info',
                'message' => 'Para fazer a assinatura, você deve preencher os dados do seu perfil.'
            ]);
        }

        // VERIFICA SE O USUÁRIO JÁ TEM ASSINATURA
        if (auth()->user()->subscribed('default')) {
            return redirect()->route('subscriptions.account');
        }

        $plans = Plan::get();

        // SE NÃO TIVER PLANO CADASTRO, RETORNA PARA O DASHBOARD
        if(!$plans) {
            return redirect()->route('dashboard')->with([
                'alert-type' => 'info',
                'message' => 'Nenhum plano disponível para assinatura.'
            ]);
        }

        return view('admin.pages.subscription.checkout', [
            'plans' => $plans,
            'user' => $user,
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

        return view('admin.pages.subscription.account', compact('invoices'));
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
