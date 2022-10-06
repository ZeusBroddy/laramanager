<?php

namespace App\Http\Controllers;

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

        return view('admin.pages.dashboard.index', [
            'latestEithUsers' => $latestEithUsers,
            'usersCount' => $usersCount,
            'universities' => $universities,
            'paths' => $paths
        ]);
    }
}
