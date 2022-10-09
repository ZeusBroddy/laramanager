<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Laravel\Cashier\Cashier;

class StripeController extends Controller
{
    public function getInvoices()
    {
        $stripeBaseUrl = config('services.stripe.base_url');

        $response = Http::withToken(config('services.stripe.secret'))
            ->get("{$stripeBaseUrl}/invoices")
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
            $key = $invoice['id'];
            $items[$key] = [];
            $items[$key]['id']   = $invoice['id'];
            $items[$key]['name'] = $invoice['customer_name'];
            $items[$key]['email'] = $invoice['customer_email'];
            $items[$key]['total'] = Cashier::formatAmount($invoice['total'], 'brl');
            $items[$key]['paid_at'] = Carbon::createFromTimestampUTC($invoice['status_transitions']['paid_at'])->format('d M Y H:i');
            $items[$key]['paid'] = $invoice['paid'];
            $items[$key]['pdf'] = $invoice['invoice_pdf'];
        endforeach;

        return $items;
    }

    public function getBalance()
    {
        $stripeBaseUrl = config('services.stripe.base_url');

        $response = Http::withToken(config('services.stripe.secret'))
            ->get("{$stripeBaseUrl}/invoices")
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
            $key = $invoice['id'];
            $items[$key] = [];
            $items[$key]['net_total'] = $invoice['total'] > 0 ? $invoice['total'] - ($invoice['total'] * 0.0399 + 39) : 0;
            $items[$key]['paid_at'] = Carbon::createFromTimestampUTC($invoice['status_transitions']['paid_at'])->format('m');
            $items[$key]['paid'] = $invoice['paid'];
        endforeach;

        $total = 0;
        foreach ($items as $month) :
            if ($month['paid'] != true) continue;
            if ($month['paid_at'] != Carbon::now()->month) continue;
            $total += $month['net_total'];
        endforeach;

        return number_format($total / 100, 2, ',', ' ');
    }
}
