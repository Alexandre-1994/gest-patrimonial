<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CostCenter;

class CostCenterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $costCenters = CostCenter::orderBy('name')->paginate(10);
        return view('cost_centers.index', compact('costCenters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = \App\Models\User::all();
        return view('cost_centers.create', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|unique:cost_centers',
            'name' => 'required',
            'description' => 'nullable',
            'manager_id' => 'required|exists:users,id'
        ]);


        // Adicionar valid_from
        $validated['valid_from'] = now();

        CostCenter::create($validated);

        return redirect()->route('cost-centers.index')
            ->with('success', 'Centro de Custo criado com sucesso.');
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
    public function edit(CostCenter $costCenter)
    {
        return view('cost_centers.edit', compact('costCenter'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CostCenter $costCenter)
    {
        $validated = $request->validate([
            'code' => 'required|unique:cost_centers,code,' . $costCenter->id,
            'name' => 'required',
            'description' => 'nullable'
        ]);

        $costCenter->update($validated);

        return redirect()->route('cost-centers.index')
            ->with('success', 'Centro de Custo atualizado com sucesso.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CostCenter $costCenter)
    {
        // Verificar se existem ativos vinculados
        if ($costCenter->assets()->exists()) {
            return back()->with('error', 'Não é possível excluir este centro de custo pois existem ativos vinculados a ele.');
        }

        $costCenter->delete();
        return redirect()->route('cost-centers.index')
            ->with('success', 'Centro de Custo removido com sucesso.');
    }
}
