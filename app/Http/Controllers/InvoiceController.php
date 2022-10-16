<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    private $repository;

    /**
     * Create a new controller instance.
     *
     * @param  \App\Models\Invoice $invoice
     * @return void
     */
    public function __construct(Invoice $invoice)
    {
        $this->repository = $invoice;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        if ($user->profile->address == null) {
            return redirect()->route('profile.edit')->with([
                'alert-type' => 'info',
                'message' => 'Para fazer a assinatura, você deve preencher os dados do seu perfil.'
            ]);
        }

        $invoices = $user->invoices()->whereNull('paid_at')->get();
        if ($invoices->isEmpty()) {
            return redirect()->route('subscriptions.account')->with([
                'alert-type' => 'info',
                'message' => 'Nenhuma mensalidade pendente.'
            ]);
        }

        return view('admin.pages.subscription.index', [
            'user' => $user,
            'invoices' => $invoices,
        ]);
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
    public function update(Request $request, $id)
    {
        $request->validate([
            // 'price_id' => ['required', 'string', 'max:255'],
            'token' => ['required', 'string', 'max:255']
        ]);

        $invoice = $this->repository->findOrFail($id);

        $response = auth()->user()->charge($invoice->total, $request->token);

        $invoice->update([
            'paid_at' =>  Carbon::createFromTimestamp($response->created),
            'stripe_id' => $response->id
        ]);

        return redirect()->route('dashboard')->with([
            'alert-type' => 'success',
            'message' => 'Assinatura criada com sucesso!'
        ]);
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
     *
     * @return \Illuminate\Http\Response
     */
    public function checkout($id)
    {
        $user = auth()->user();
        if ($user->profile->address == null) {
            return redirect()->route('profile.edit')->with([
                'alert-type' => 'info',
                'message' => 'Para fazer a assinatura, você deve preencher os dados do seu perfil.'
            ]);
        }

        $invoice = $user->invoices()->findOrFail($id);

        return view('admin.pages.subscription.checkout', [
            'invoice' => $invoice,
            'user' => $user,
            // 'intent' => auth()->user()->createSetupIntent(),
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function account()
    {
        // Retornar faturas do usuario autenticado
        $invoices = auth()->user()->invoices()->get();

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
