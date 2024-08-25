<?php

namespace App\Http\Controllers;

use App\Models\AssetMovement;
use App\Models\Asset;
use Illuminate\Http\Request;

class AssetMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movements = AssetMovement::all();
        // Certifique-se de que a data é manipulada como Carbon, se necessário
        foreach ($movements as $movement) {
            $movement->moved_at = \Carbon\Carbon::parse($movement->moved_at);
        }
        return view('asset_movements.index', compact('movements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::all();
        return view('asset_movements.create', compact('assets'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'old_location' => 'required|string|max:255',
            'new_location' => 'required|string|max:255',
            'moved_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        AssetMovement::create($validated);
        return redirect()->route('asset_movements.index')->with('success', 'Movement registered successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetMovement $assetMovement)
    {
        return view('asset_movements.show', compact('assetMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetMovement $assetMovement)
    {
        $assets = Asset::all();
        return view('asset_movements.edit', compact('assetMovement', 'assets'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetMovement $assetMovement)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'old_location' => 'required|string|max:255',
            'new_location' => 'required|string|max:255',
            'moved_at' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $assetMovement->update($validated);
        return redirect()->route('asset_movements.index')->with('success', 'Movement updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetMovement $assetMovement)
    {
        $assetMovement->delete();
        return redirect()->route('asset_movements.index')->with('success', 'Movement deleted successfully.');
    }
}
