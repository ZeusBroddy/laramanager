<?php

namespace App\Http\Controllers;

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
        $users = User::with('profile.university')->get();
        $universities = University::withCount('profiles')->get();

        return view('dashboard.index', [
            'users' => $users,
            'universities' => $universities
        ]);
    }
}
