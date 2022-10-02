<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Laravel\Cashier\Cashier;

class TransactionController extends Controller
{
    private $stripeBaseUrl;

    public function __construct()
    {
        $this->stripeBaseUrl = config('services.stripe.base_url');
        $this->middleware('can:isAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $response = Http::withToken(config('services.stripe.secret'))
            ->get("{$this->stripeBaseUrl}/invoices")
            ->json();

        // SE OCORRER ERRO NO STRIPE
        if (Arr::exists($response, 'error')) {
            return redirect()->route('plans.index')->with([
                'alert-type' => 'error',
                'message' => $response['error']['message']
            ]);
        }

        $items = [];
        foreach ($response['data'] as $invoice) :
            $key = $invoice->id;
            $items[$key] = [];
            $items[$key]['id']   = $invoice->id;
            $items[$key]['name'] = $invoice->customer_name;
            $items[$key]['email'] = $invoice->customer_email;
            $items[$key]['total'] = Cashier::formatAmount($invoice->total, 'brl');
            $items[$key]['paid_at'] = Carbon::createFromTimestampUTC($invoice->status_transitions->paid_at)->format('d M H:i');
            $items[$key]['paid'] = $invoice->paid;
            $items[$key]['pdf'] = $invoice->invoice_pdf;
        endforeach;

        return view('admin.pages.transactions.index', compact('items'));
    }
}
