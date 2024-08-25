<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMovement;
use Illuminate\Http\Request;
use App\Models\User;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $ativos = Asset::all();
        return view('ativos.index', compact('ativos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::all(); // Obtém todos os usuários
        return view('ativos.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'serial_number' => 'required|string|unique:assets',
            'acquisition_date' => 'required|date',
            'acquisition_value' => 'required|numeric',
            'useful_life' => 'required|integer',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'state' => 'required|in:in_use,stored,to_be_scrapped',
            'user_id' => 'nullable|exists:users,id',
            'is_scrapped' => 'boolean',
        ]);
        // Asset::create($validated);
        // return redirect()->route('ativos.index')->with('success', 'Asset created successfully.');
        // Verifique se há um ativo existente com o mesmo número de série
        $existingAsset = Asset::where('serial_number', $validated['serial_number'])->first();

        if ($existingAsset) {
            // Se um ativo com o mesmo número de série já existir, registre o movimento
            if ($existingAsset->location !== $validated['location']) {
                AssetMovement::create([
                    'asset_id' => $existingAsset->id,
                    'old_location' => $existingAsset->location,
                    'new_location' => $validated['location'],
                    'moved_at' => now(),
                    'notes' => 'Localização atualizada',
                ]);
            }

            // Atualize o ativo existente
            $existingAsset->update($validated);
        } else {
            // Se o ativo não existir, crie um novo ativo
            Asset::create($validated);
        }

        return redirect()->route('ativos.index')->with('success', 'Asset created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        return view('ativos.show', compact('asset'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $users = User::all(); // Obtém todos os usuários
        return view('ativos.edit', compact('asset', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'serial_number' => 'required|string|unique:assets,serial_number,' . $asset->id,
            'acquisition_date' => 'required|date',
            'acquisition_value' => 'required|numeric',
            'useful_life' => 'required|integer',
            'location' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'supplier' => 'required|string|max:255',
            'state' => 'required|in:in_use,stored,to_be_scrapped',
            'user_id' => 'nullable|exists:users,id',
            'is_scrapped' => 'boolean',
        ]);

        $asset->update($validated);
        return redirect()->route('ativos.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('ativos.index')->with('success', 'Asset deleted successfully.');
    }

    public function dashboard()
    {
        $totalAssets = Asset::count();
        $totalCategories = Asset::distinct('category')->count();

        $categories = Asset::select('category')->distinct()->pluck('category');
        $ativosByCategory = Asset::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        $locations = Asset::select('location')->distinct()->pluck('location');
        $ativosByLocation = Asset::selectRaw('location, COUNT(*) as count')
            ->groupBy('location')
            ->pluck('count', 'location');

        return view('dashboard', compact('totalAssets', 'totalCategories', 'categories', 'ativosByCategory', 'locations', 'ativosByLocation'));
    }
}
