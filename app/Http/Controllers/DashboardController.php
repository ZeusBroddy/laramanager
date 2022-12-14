<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Ledger;
use App\Models\Path;
use App\Models\University;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $latestEithUsers = User::with('profile')
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();
        $usersCount = User::get()->count();
        $universities = University::withCount('profiles')->get();
        $paths = Path::withCount('profiles')->get();

        $invoices = Invoice::whereNotNull('paid_at')
            ->with('user')
            ->take(20)
            ->get();

        $incomesInvoice = Invoice::whereNotNull('paid_at')->sum('total') / 100;
        $incomesLedger = Ledger::where('type', 'income')->sum('amount');

        $incomes = $incomesInvoice + $incomesLedger;
        $expenses = Ledger::where('type', 'expense')->sum('amount');
        $balance = $incomes - $expenses;

        $totalInvoicesByMonth = DB::table('invoices')
            ->select(DB::raw('SUM(total / 100) as total_invoice, MONTH(created_at) as month, YEAR(created_at) as year'))
            ->groupBy(DB::raw('YEAR(created_at) ASC, MONTH(created_at) ASC'))
            ->get();

        return view('admin.pages.dashboard.index', [
            'latestEithUsers' => $latestEithUsers,
            'usersCount' => $usersCount,
            'universities' => $universities,
            'paths' => $paths,
            'invoices' => $invoices,
            'incomes' => $incomes,
            'expenses' => $expenses,
            'balance' => $balance,
            'totalInvoicesByMonth' => $totalInvoicesByMonth
        ]);
    }
}
