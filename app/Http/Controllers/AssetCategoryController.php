<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AssetCategory;

class AssetCategoryController extends Controller
{
    public function index()
    {
        $categories = AssetCategory::latest()->paginate(10);
        return view('asset_categories.index', compact('categories'));
    }

    public function create()
    {
        return view('asset_categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:asset_categories',
            'description' => 'nullable|string'
        ]);
        $validated['code'] = strtoupper(substr(str_replace(' ', '', $request->name), 0, 3)) . rand(100, 999);
        AssetCategory::create($validated);

        return redirect()->route('asset-categories.index')
            ->with('success', 'Categoria criada com sucesso.');
    }

    public function edit(AssetCategory $category)
    {
        return view('asset_categories.edit', compact('category'));
    }

    public function update(Request $request, AssetCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:asset_categories,name,' . $category->id,
            'description' => 'nullable|string'
        ]);

        $category->update($validated);

        return redirect()->route('asset-categories.index')
            ->with('success', 'Categoria atualizada com sucesso.');
    }

    public function destroy(AssetCategory $category)
    {
        if ($category->assets()->exists()) {
            return back()->with('error', 'Não é possível excluir uma categoria com ativos vinculados.');
        }

        $category->delete();

        return redirect()->route('asset-categories.index')
            ->with('success', 'Categoria excluída com sucesso.');
    }
}
