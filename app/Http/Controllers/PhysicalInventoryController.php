<?php

namespace App\Http\Controllers;

use App\Models\PhysicalInventory;
use Illuminate\Http\Request;

class PhysicalInventoryController extends Controller
{
    public function index()
    {
        $inventories = PhysicalInventory::all();
        return view('physical_inventories.index', compact('inventories'));
    }

    public function create()
    {
        return view('physical_inventories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'inventory_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        PhysicalInventory::create($validated);
        return redirect()->route('physical_inventories.index')->with('success', 'Inventário criado com sucesso.');
    }

    public function show($id)
    {
        $inventory = PhysicalInventory::findOrFail($id);
        return view('physical_inventories.show', compact('inventory'));
    }

    public function edit($id)
    {
        $inventory = PhysicalInventory::findOrFail($id);
        return view('physical_inventories.edit', compact('inventory'));
    }

    public function update(Request $request, $id)
    {
        $inventory = PhysicalInventory::findOrFail($id);

        $validated = $request->validate([
            'inventory_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $inventory->update($validated);
        return redirect()->route('physical_inventories.index')->with('success', 'Inventário atualizado com sucesso.');
    }

    public function destroy($id)
    {
        $inventory = PhysicalInventory::findOrFail($id);
        $inventory->delete();
        return redirect()->route('physical_inventories.index')->with('success', 'Inventário excluído com sucesso.');
    }
}
