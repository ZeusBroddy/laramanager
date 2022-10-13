<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
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

        $invoices = Invoice::whereNotNull('paid_at')
            ->with('user')
            ->take(12)
            ->get();

        $balance = Invoice::whereNotNull('paid_at')->sum('total') / 100;

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
