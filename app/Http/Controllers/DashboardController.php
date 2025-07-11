<?php

namespace App\Http\Controllers;

use App\Models\Positions;
use App\Models\Users;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dashboard', [
            'users' => Users::select('uuid', 'name')->get(),
            'positions' => Positions::select('uuid', 'name')->get()
        ]);
    }
}
