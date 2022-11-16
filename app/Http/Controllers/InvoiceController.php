<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Plan;
use App\Models\User;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $user = User::findOrFail($id);

        return view('admin.pages.subscription.create', compact('user'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $user)
    {
        $request->validate([
            'description' => ['nullable', 'string', 'max:255'],
            'total' => ['required', "regex:/^\d+(\.\d{1,2})?$/"],
            'due_date' => ['required', 'date']
        ]);

        $this->repository->create([
            'user_id' => $user,
            'description' => $request->description,
            'total' => $request->total,
            'net_total' => $request->total * 100,
            'due_date' => $request->due_date
        ]);

        return redirect()->route('users.show', $user)->with([
            'alert-type' => 'success',
            'message' => 'Registro criado com sucesso!'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $invoice = $this->repository->with('user')->findOrFail($id);

        return view('admin.pages.subscription.edit', compact('invoice'));
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
        $request->validate([
            'description' => ['nullable', 'string', 'max:255'],
            'total' => ['required', "regex:/^\d+(\.\d{1,2})?$/"],
            'due_date' => ['required', 'date']
        ]);

        $invoice = $this->repository->findOrFail($id);

        $invoice->update([
            'description' => $request->description,
            'total' => $request->total,
            'net_total' => $request->total * 100,
            'due_date' => $request->due_date
        ]);

        return redirect()->route('users.index')->with([
            'alert-type' => 'success',
            'message' => 'Registro atualizado com sucesso!'
        ]);
    }

    /**
     * Show the form for deleting the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $invoice = $this->repository->findOrFail($id);

        return view('admin.pages.users._partials.invoice-delete', compact('invoice'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $invoice = $this->repository->findOrFail($id);
        $invoice->delete();

        return redirect()->route('users.index')->with([
            'alert-type' => 'success',
            'message' => 'Registro deletado com sucesso!',
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function payable()
    {
        $user = auth()->user();
        if ($user->profile->address == null) {
            return redirect()->route('profile.edit')->with([
                'alert-type' => 'info',
                'message' => 'Para fazer a assinatura, você deve preencher os dados do seu perfil.'
            ]);
        }

        $invoices = $user->invoices()->whereNull('paid_at')->get();

        return view('admin.pages.subscription.payable', [
            'user' => $user,
            'invoices' => $invoices,
        ]);
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
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function paying(Request $request, $id)
    {
        $request->validate([
            'token' => ['required', 'string', 'max:255']
        ]);

        $user = auth()->user();
        $invoice = $user->invoices()->findOrFail($id);

        try {
            $response = $user->charge($invoice->total, $request->token);
          } catch(\Stripe\Exception\CardException $e) {
            return redirect()->route('dashboard')->with([
                'alert-type' => 'error',
                'message' => $e->getError()->message
            ]);
          }

        $invoice->update([
            'paid_at' =>  Carbon::createFromTimestamp($response->created),
            'stripe_id' => $response->id
        ]);

        return redirect()->route('dashboard')->with([
            'alert-type' => 'success',
            'message' => 'Pagamento realizado com sucesso!'
        ]);
    }

    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function history()
    {
        // Retornar faturas do usuario autenticado
        $invoices = auth()->user()->invoices()->whereNotNull('paid_at')->get();

        return view('admin.pages.subscription.history', compact('invoices'));
    }

    /**
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
