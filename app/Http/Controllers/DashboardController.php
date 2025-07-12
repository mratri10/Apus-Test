<?php

namespace App\Http\Controllers;

use App\Models\Positions;
use App\Models\Tasks;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $usersWithPositions = DB::table('users as u')
            ->leftJoin('user_positions as up', 'up.user_id', '=', 'u.uuid')
            ->leftJoin('positions as p', 'up.position_id', '=', 'p.uuid')
            ->select('u.uuid', 'u.name', 'p.name as position')
            ->distinct('u.uuid')
            ->orderBy('u.uuid')
            ->orderByDesc('up.updated_at')
            ->get();

        $userWithTasks = DB::table('users as u')
            ->Join('tasks as t', 't.user_id', '=', 'u.uuid')
            ->select('u.name', 't.todo', 't.created_at', 't.uuid')
            ->orderByDesc('t.created_at')
            ->get();
        return Inertia::render('Dashboard/Dashboard', [
            'users' => $usersWithPositions,
            'positions' => Positions::select('uuid', 'name')->get(),
            'tasks' => $userWithTasks
        ]);
    }
}
