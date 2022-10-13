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
    public function __construct()
    {
        $this->middleware('can:isAdmin');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // $invoices = (new StripeController)->getInvoices();

        return view('admin.pages.transactions.index');
    }
}
