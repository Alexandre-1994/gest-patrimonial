<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetMaintenance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            // Dados para o filtro de categorias
            $allCategories = AssetCategory::select('id', 'name')->get();

            // Estatísticas para os cards
            $totalAssets = Asset::count();
            $totalCategories = AssetCategory::count();
            $totalValue = Asset::sum('current_value');
            $maintenanceCount = Asset::where('status', 'maintenance')->count();
            $depreciatedAssets = Asset::where('conservation_status', 'poor')->count();
            $expiringWarranties = Asset::whereNotNull('warranty_end')
                ->where('warranty_end', '<=', now()->addDays(30))
                ->count();

            // Dados para o gráfico de categorias
            $categoryData = AssetCategory::withCount('assets')->get();
            $categories = $categoryData->pluck('name');
            $assetsByCategory = $categoryData->pluck('assets_count');

            // Dados para o gráfico de localização
            $locationData = Asset::select('location')
                ->selectRaw('COUNT(*) as total')
                ->groupBy('location')
                ->get();
            $locations = $locationData->pluck('location');
            $assetsByLocation = $locationData->pluck('total');

            // Ativos que precisam de atenção
            $alertAssets = Asset::with('category')
                ->where('status', 'maintenance')
                ->orWhere('conservation_status', 'poor')
                ->orWhereRaw('current_value < (purchase_value * 0.2)')
                ->orWhere(function ($query) {
                    $query->whereNotNull('warranty_end')
                        ->where('warranty_end', '<=', now()->addDays(30));
                })
                ->get()
                ->map(function ($asset) {
                    $asset->status_color = $this->getStatusColor($asset->status);
                    $asset->alert_message = $this->getAlertMessage($asset);
                    return $asset;
                });

            return view('welcome', compact(
                'allCategories',
                'totalAssets',
                'totalCategories',
                'totalValue',
                'maintenanceCount',
                'depreciatedAssets',
                'expiringWarranties',
                'categories',
                'assetsByCategory',
                'locations',
                'assetsByLocation',
                'alertAssets'
            ));
        } catch (\Exception $e) {
            return view('welcome')->with('error', 'Erro ao carregar dados do dashboard: ' . $e->getMessage());
        }
    }

    public function filterData(Request $request)
    {
        try {
            $query = Asset::query();

            if ($request->date_start) {
                $query->whereDate('created_at', '>=', $request->date_start);
            }

            if ($request->date_end) {
                $query->whereDate('created_at', '<=', $request->date_end);
            }

            if ($request->category) {
                $query->where('category_id', $request->category);
            }

            $data = [
                'totalAssets' => $query->count(),
                'totalValue' => $query->sum('current_value'),
                'maintenanceCount' => $query->where('status', 'maintenance')->count(),

                'assetsByCategory' => AssetCategory::withCount(['assets' => function ($query) use ($request) {
                    if ($request->date_start) {
                        $query->whereDate('created_at', '>=', $request->date_start);
                    }
                    if ($request->date_end) {
                        $query->whereDate('created_at', '<=', $request->date_end);
                    }
                }])->pluck('assets_count'),

                'assetsByLocation' => $query->select('location')
                    ->selectRaw('COUNT(*) as total')
                    ->groupBy('location')
                    ->pluck('total')
            ];

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erro ao filtrar dados: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getStatusColor($status)
    {
        return [
            'active' => 'success',
            'maintenance' => 'warning',
            'inactive' => 'danger',
            'disposed' => 'secondary'
        ][$status] ?? 'primary';
    }

    private function getAlertMessage($asset)
    {
        if ($asset->status === 'maintenance') {
            return 'Em manutenção';
        }
        if ($asset->conservation_status === 'poor') {
            return 'Estado de conservação ruim';
        }
        if ($asset->current_value < ($asset->purchase_value * 0.2)) {
            return 'Altamente depreciado';
        }
        if ($asset->warranty_end && $asset->warranty_end <= now()->addDays(30)) {
            return 'Garantia próxima do vencimento';
        }
        return 'Necessita atenção';
    }
}
