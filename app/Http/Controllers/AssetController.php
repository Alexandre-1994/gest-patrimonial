<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\CostCenter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


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
        $lastAsset = Asset::orderBy('id', 'desc')->first();
        $lastNumber = $lastAsset ? intval(substr($lastAsset->code, 3)) : 0;
        $nextNumber = $lastNumber + 1;
        $code = 'AST' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        $categories = AssetCategory::all();
        $costCenters = CostCenter::all();
        $users = \App\Models\User::all();
        return view('assets.create', compact('categories', 'costCenters', 'users', 'code'));
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
            'criticality_level' => 'required|in:low,medium,high,critical',
            'warranty_start' => 'nullable|date',
            'warranty_end' => 'nullable|date|after:warranty_start',
            'warranty_details' => 'nullable|string'
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

    public function byCategory()
    {
        $categoriesWithAssets = AssetCategory::withCount('assets')
            ->with(['assets' => function ($query) {
                $query->select('id', 'category_id', 'name', 'code', 'status', 'current_value');
            }])
            ->orderBy('name')
            ->get();

        $totalValue = Asset::sum('current_value');

        return view('assets.by-category', compact('categoriesWithAssets', 'totalValue'));
    }

    public function totalValue()
    {
        $summary = [
            'total_value' => Asset::sum('current_value'),
            'total_purchase_value' => Asset::sum('purchase_value'),
            'total_depreciation' => Asset::sum('purchase_value') - Asset::sum('current_value'),
            'total_assets' => Asset::count()
        ];

        // Corrigindo a query das categorias
        $valuesByCategory = AssetCategory::withSum('assets as assets_sum_current_value', 'current_value')
            ->withCount('assets')
            ->orderByDesc('assets_sum_current_value')
            ->get();

        $valuesByStatus = Asset::select('status')
            ->selectRaw('COUNT(*) as total_assets')
            ->selectRaw('SUM(current_value) as total_value')
            ->groupBy('status')
            ->get();

        return view('assets.total-value', compact('summary', 'valuesByCategory', 'valuesByStatus'));
    }

    public function inMaintenance()
    {
        $assetsInMaintenance = Asset::where('status', 'maintenance')
            ->with(['category', 'costCenter', 'responsibleUser', 'maintenances' => function ($query) {
                $query->latest();
            }])
            ->latest()
            ->paginate(10);

        $summary = [
            'total_in_maintenance' => Asset::where('status', 'maintenance')->count(),
            'total_maintenance_value' => Asset::where('status', 'maintenance')->sum('current_value'),
            'total_maintenance_cost' => Asset::where('status', 'maintenance')->sum('maintenance_cost_total'),
        ];

        return view('assets.maintenance', compact('assetsInMaintenance', 'summary'));
    }
    public function depreciated()
    {
        $depreciatedAssets = Asset::where('current_value', '<', DB::raw('purchase_value * 0.5'))
            ->with(['category', 'costCenter', 'responsibleUser'])
            ->latest()
            ->paginate(10);

        $summary = [
            'total_depreciated' => Asset::where('current_value', '<', DB::raw('purchase_value * 0.5'))->count(),
            'total_original_value' => Asset::where('current_value', '<', DB::raw('purchase_value * 0.5'))->sum('purchase_value'),
            'total_current_value' => Asset::where('current_value', '<', DB::raw('purchase_value * 0.5'))->sum('current_value'),
            'total_depreciation' => Asset::where('current_value', '<', DB::raw('purchase_value * 0.5'))
                ->selectRaw('SUM(purchase_value - current_value) as total_depreciation')
                ->first()
                ->total_depreciation
        ];

        return view('assets.depreciated', compact('depreciatedAssets', 'summary'));
    }

    public function warranty()
    {
        $expiringWarranties = Asset::whereNotNull('warranty_end')
            ->where('warranty_end', '>=', now())
            ->where('warranty_end', '<=', now()->addMonths(3))
            ->with(['category', 'costCenter', 'responsibleUser'])
            ->orderBy('warranty_end')
            ->paginate(10);

        $summary = [
            'total_expiring' => Asset::whereNotNull('warranty_end')
                ->where('warranty_end', '>=', now())
                ->where('warranty_end', '<=', now()->addMonths(3))
                ->count(),
            'expiring_30_days' => Asset::whereNotNull('warranty_end')
                ->where('warranty_end', '>=', now())
                ->where('warranty_end', '<=', now()->addDays(30))
                ->count(),
            'value_at_risk' => Asset::whereNotNull('warranty_end')
                ->where('warranty_end', '>=', now())
                ->where('warranty_end', '<=', now()->addMonths(3))
                ->sum('current_value'),
        ];

        return view('assets.warranty', compact('expiringWarranties', 'summary'));
    }

    public function getNextCode()
    {
        $lastAsset = Asset::orderBy('id', 'desc')->first();
        $lastNumber = $lastAsset ? intval(substr($lastAsset->code, 3)) : 0;
        $nextNumber = $lastNumber + 1;
        $code = 'AST' . str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

        return response()->json(['code' => $code]);
    }
}
