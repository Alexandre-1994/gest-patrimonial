<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\CostCenter;
use Illuminate\Http\Request;


class AssetController extends Controller
{
    public function index(Request $request)
    {
        $assets = Asset::with(['category', 'costCenter']);

        // Aplicar filtros
        if ($request->search) {
            $assets->where(function ($query) use ($request) {
                $query->where('code', 'like', "%{$request->search}%")
                    ->orWhere('name', 'like', "%{$request->search}%");
            });
        }

        if ($request->category) {
            $assets->where('category_id', $request->category);
        }

        if ($request->status) {
            $assets->where('status', $request->status);
        }

        if ($request->location) {
            $assets->where('location', $request->location);
        }

        $assets = $assets->orderBy('created_at', 'desc')->paginate(10);
        $categories = AssetCategory::all(); // Adicionando categorias

        return view('assets.index', compact('assets', 'categories'));
    }

    public function create()
    {
        $categories = AssetCategory::all();
        $costCenters = CostCenter::all();
        $users = \App\Models\User::all();
        return view('assets.create', compact('categories', 'costCenters', 'users'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:assets',
            'name' => 'required',
            'category_id' => 'required|exists:asset_categories,id',
            'cost_center_id' => 'required|exists:cost_centers,id',
            'purchase_value' => 'required|numeric',
            'purchase_date' => 'required|date',
            'location' => 'required',  // Adicionado este campo
            'status' => 'required|in:active,inactive,maintenance,disposed',
            'conservation_status' => 'required|in:excellent,good,regular,poor',
            'depreciation_rate' => 'required|numeric|between:0,100',
            'current_value' => 'nullable|numeric',
            'responsible_user_id' => 'required|exists:users,id',
            'serial_number' => 'nullable',
            'brand' => 'nullable',
            'model' => 'nullable',
            'technical_specifications' => 'nullable',
            'life_span_months' => 'required|integer|min:1',
            'criticality_level' => 'required|in:low,medium,high,critical'
        ]);
        // Definir valores padrão se necessário
        $validated['current_value'] = $validated['current_value'] ?? $validated['purchase_value'];
        Asset::create($validated);

        return redirect()->route('assets.index')
            ->with('success', 'Ativo criado com sucesso.');
    }

    public function edit(Asset $asset)
    {
        $categories = AssetCategory::all();
        $costCenters = CostCenter::all();
        $users = \App\Models\User::all();

        return view('assets.edit', compact('asset', 'categories', 'costCenters', 'users'));
    }

    public function update(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'code' => 'required|unique:assets,code,' . $asset->id,
            'name' => 'required',
            // outras validações
        ]);

        $asset->update($validated);
        return redirect()->route('assets.index')
            ->with('success', 'Ativo atualizado com sucesso.');
    }

    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')
            ->with('success', 'Ativo removido com sucesso.');
    }

    public function show(Asset $asset)
    {
        $asset->load(['category', 'costCenter', 'maintenances', 'movements']);
        return view('assets.show', compact('asset'));
    }
}
