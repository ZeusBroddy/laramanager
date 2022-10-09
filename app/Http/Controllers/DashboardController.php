<?php

namespace App\Http\Controllers;

use App\Models\Ledger;
use App\Models\Path;
use App\Models\University;
use App\Models\User;

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

        $invoices = (new StripeController)->getInvoices();

        $balance = (new StripeController)->getBalance();

        $expenses = Ledger::where('type', 'expense')->sum('amount');

        return view('admin.pages.dashboard.index', [
            'latestEithUsers' => $latestEithUsers,
            'usersCount' => $usersCount,
            'universities' => $universities,
            'paths' => $paths,
            'invoices' => $invoices,
            'balance' => $balance,
            'expenses' => $expenses
        ]);
    }
}
