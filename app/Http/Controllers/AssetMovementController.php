<?php

namespace App\Http\Controllers;

use App\Models\AssetMovement;
use App\Models\Asset;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\CostCenter;


class AssetMovementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $movements = AssetMovement::with(['asset', 'fromUser', 'toUser'])
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('asset', function ($q) use ($request) {
                    $q->where('name', 'like', "%{$request->search}%")
                        ->orWhere('code', 'like', "%{$request->search}%");
                })
                    ->orWhere('from_location', 'like', "%{$request->search}%")
                    ->orWhere('to_location', 'like', "%{$request->search}%");
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status', $request->status);
            })
            ->when($request->date, function ($query) use ($request) {
                $query->whereDate('movement_date', $request->date);
            })
            ->orderByDesc('movement_date')
            ->paginate(10);  // Mudando de get() para paginate()

        return view('asset-movements.index', compact('movements'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $assets = Asset::all();
        $users = User::all();
        $costCenters = CostCenter::where('status', 'active')->get();

        return view('asset-movements.create', compact('assets', 'users', 'costCenters'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'to_user_id' => 'required|exists:users,id',
            'to_location' => 'required',
            'reason' => 'required',
            'movement_date' => 'required|date',
            'from_cost_center_id' => 'required|exists:cost_centers,id',
            'to_cost_center_id' => 'required|exists:cost_centers,id'
        ]);

        // Buscar o ativo
        $asset = Asset::findOrFail($validated['asset_id']);

        $validated['requested_by'] = auth()->id();

        $movement = AssetMovement::create([
            'asset_id' => $validated['asset_id'],
            'from_user_id' => $asset->responsible_user_id,
            'from_location' => $asset->location,
            'from_cost_center_id' => $validated['from_cost_center_id'],
            'to_user_id' => $validated['to_user_id'],
            'to_location' => $validated['to_location'],
            'to_cost_center_id' => $validated['to_cost_center_id'],
            'reason' => $validated['reason'],
            'movement_date' => $validated['movement_date'],
            'status' => 'pending',
            'requested_by' => $validated['requested_by']
        ]);

        $asset->update([
            'responsible_user_id' => $validated['to_user_id'],
            'location' => $validated['to_location']
        ]);

        return redirect()->back()
            ->with('success', 'Movimentação registrada com sucesso!');
    }

    /**
     * Display the specified resource.
     */
    public function show(AssetMovement $assetMovement)
    {
        return view('asset-movements.show', compact('assetMovement'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AssetMovement $assetMovement)
    {
        $assets = Asset::all();
        $costCenters = CostCenter::where('status', 'active')->get();

        return view('asset-movements.edit', compact('assetMovement', 'assets', 'costCenters'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AssetMovement $assetMovement)
    {
        $validated = $request->validate([
            'asset_id' => 'required|exists:assets,id',
            'from_location' => 'required|string|max:255',
            'to_location' => 'required|string|max:255',
            'from_cost_center_id' => 'required|exists:cost_centers,id',
            'to_cost_center_id' => 'required|exists:cost_centers,id',
            'movement_date' => 'required|date',
            'status' => 'required|in:pending,in_transit,completed,cancelled',
            'reason' => 'required|string',
            'notes' => 'nullable|string'
        ]);

        $assetMovement->update($validated);

        return redirect()->route('asset-movements.index')
            ->with('success', 'Movimentação atualizada com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AssetMovement $assetMovement)
    {
        $assetMovement->delete();
        return redirect()->route('asset-movements.index')->with('success', 'Movement deleted successfully.');
    }

    public function approve(AssetMovement $assetMovement)
    {
        // Durante o desenvolvimento, aprove automaticamente
        $assetMovement->update([
            'status' => 'completed',
            'approved_by' => auth()->id(), // Usuário logado
            'approved_at' => now()
        ]);

        return redirect()->route('asset-movements.show', $assetMovement)
            ->with('success', 'Movimentação aprovada com sucesso!');
    }

    public function reject(AssetMovement $assetMovement)
    {
        $assetMovement->update([
            'status' => 'cancelled',
            'approved_by' => auth()->id(), // Usuário logado
            'approved_at' => now()
        ]);

        return redirect()->route('asset-movements.show', $assetMovement)
            ->with('warning', 'Movimentação rejeitada.');
    }
}
