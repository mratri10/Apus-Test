<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Positions;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class PositionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Dashboard/PositionForm', [
            'positions' => Positions::select('uuid', 'name')->get()
        ]);
    }
    public function userList()
    {
        return Inertia::render('Dashboard/UserList', [
            'positions' => Positions::select('uuid', 'name')->get()
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create() {}

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        Positions::create([
            'uuid' => (string) STR::uuid(),
            'name' => $request->name
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {}

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string'
        ]);

        $position = Positions::findOrFail($id);
        $position->name = $request->name;
        $position->save();
        return;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $position = Positions::findOrFail($id);
        $position->delete();

        return;
    }
}
