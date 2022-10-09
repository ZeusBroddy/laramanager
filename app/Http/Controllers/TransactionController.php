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
        $invoices = (new StripeController)->getInvoices();

        return view('admin.pages.transactions.index', compact('invoices'));
    }
}
