<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Contagens básicas
        $totalAssets = Asset::count();
        $totalCategories = AssetCategory::count();
        $totalValue = Asset::sum('current_value');
        $maintenanceCount = Asset::where('status', 'maintenance')->count();

        // Dados para o gráfico de Ativos por Categoria
        $categories = AssetCategory::pluck('name')->toArray();
        $assetsByCategory = AssetCategory::withCount('assets')
            ->pluck('assets_count')
            ->toArray();

        // Dados para o gráfico de Ativos por Localização
        $locations = Asset::distinct('location')->pluck('location')->toArray();
        $assetsByLocation = collect($locations)->map(function ($location) {
            return Asset::where('location', $location)->count();
        })->toArray();

        // Ativos que precisam de atenção
        $alertAssets = Asset::with('category')
            ->where(function ($query) {
                $query->where('status', 'maintenance')
                    // Ativos com garantia próxima do vencimento (30 dias)
                    ->orWhereRaw('warranty_end BETWEEN NOW() AND DATE_ADD(NOW(), INTERVAL 30 DAY)')
                    // Ativos com manutenção preventiva pendente
                    ->orWhereHas('maintenances', function ($q) {
                        $q->where('scheduled_date', '<=', now())
                            ->where('status', 'pending');
                    })
                    // Ativos depreciados além de 70%
                    ->orWhereRaw('current_value <= (purchase_value * 0.3)');
            })
            ->get()
            ->map(function ($asset) {
                $asset->status_color = $this->getStatusColor($asset->status);
                $asset->alert_message = $this->getAlertMessage($asset);
                return $asset;
            });

        return view('welcome', compact(
            'totalAssets',
            'totalCategories',
            'totalValue',
            'maintenanceCount',
            'categories',
            'assetsByCategory',
            'locations',
            'assetsByLocation',
            'alertAssets'
        ));
    }

    private function getStatusColor($status)
    {
        return match ($status) {
            'active' => 'success',
            'maintenance' => 'warning',
            'inactive' => 'danger',
            default => 'secondary'
        };
    }

    private function getAlertMessage($asset)
    {
        if ($asset->status === 'maintenance') {
            return 'Em manutenção';
        }

        if ($asset->warranty_end && $asset->warranty_end->between(now(), now()->addDays(30))) {
            return 'Garantia próxima do vencimento';
        }

        if ($asset->current_value <= ($asset->purchase_value * 0.3)) {
            return 'Alto nível de depreciação';
        }

        $pendingMaintenance = $asset->maintenances()
            ->where('scheduled_date', '<=', now())
            ->where('status', 'pending')
            ->first();

        if ($pendingMaintenance) {
            return 'Manutenção preventiva pendente';
        }

        return 'Necessita atenção';
    }

    public function filterData(Request $request)
    {
        $query = Asset::query();

        if ($request->filled('date_start') && $request->filled('date_end')) {
            $query->whereBetween('purchase_date', [
                $request->date_start,
                $request->date_end
            ]);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // ... resto da lógica de filtro

        return response()->json([
            'assetsByCategory' => $query->groupBy('category_id')->count(),
            'assetsByLocation' => $query->groupBy('location')->count(),
            // ... outros dados necessários
        ]);
    }
}
