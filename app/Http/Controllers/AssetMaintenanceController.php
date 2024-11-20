<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AssetMaintenanceController extends Controller
{
    public function store(Request $request, Asset $asset)
    {
        $validated = $request->validate([
            'type' => 'required',
            'scheduled_date' => 'required|date',
            'description' => 'required',
            'cost' => 'required|numeric',
            'service_provider' => 'required'
        ]);

        $maintenance = $asset->maintenances()->create($validated);
        $asset->updateMaintenanceCosts();

        return redirect()->back()
            ->with('success', 'Manutenção agendada com sucesso!');
    }
}
