<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use App\Models\AssetMovement;
use App\Models\AssetCategory;
use App\Models\CostCenter;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreAssetRequest;
use Illuminate\Foundation\Http\FormRequest;

class AssetController extends Controller
{

    public function authorize()
    {
        return true; // Permita que qualquer usuário use
    }

    public function rules()
    {
        return [
            'email' => 'required|email',
            'password' => 'required|min:6',
            // Adicione outras regras conforme necessário
        ];
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $assets = Asset::with(['category', 'responsible'])
            ->latest()
            ->paginate(15);

        return view('assets.index', compact('assets'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = AssetCategory::all();
        $costCenters = CostCenter::all();
        $users = User::all();

        return view('assets.create', compact('categories', 'costCenters', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // $validated = $request->validated();
        // Validação direta no controlador
        $validated = $request->validate([
            'name' => 'required|string|max:255', // Nome é obrigatório, texto e limitado a 255 caracteres
            'description' => 'nullable|string|max:1000', // Descrição é opcional, texto e limitada a 1000 caracteres
            'serial_number' => 'required|string|unique:assets,serial_number|max:100',
        ]);

        DB::transaction(function () use ($validated, $request) {
            $asset = Asset::create($validated);

            // Handle documents upload
            if ($request->hasFile('documents')) {
                foreach ($request->file('documents') as $document) {
                    $path = $document->store('assets/documents', 'public');
                    $asset->documents()->create([
                        'type' => $request->document_type,
                        'title' => $document->getClientOriginalName(),
                        'file_path' => $path
                    ]);
                }
            }

            // Handle photos upload
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $photo) {
                    $path = $photo->store('assets/photos', 'public');
                    $asset->photos()->create([
                        'file_path' => $path,
                        'is_primary' => $asset->photos()->count() === 0
                    ]);
                }
            }

            // Handle tags
            if ($request->has('tags')) {
                $asset->tags()->sync($request->tags);
            }
        });

        return redirect()->route('assets.index')
            ->with('success', 'Ativo cadastrado com sucesso!');

        // return response()->json([
        //     "a" => "AAAAA",
        //     'B' => "BBBB"
        // ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Asset $asset)
    {
        $asset->load([
            'category',
            'responsible',
            'costCenter',
            'maintenances',
            'documents',
            'movements',
            'photos',
            'tags',
            'relatedAssets'
        ]);

        return view('assets.show', compact('asset'));
    }

    // public function show()
    // {


    //     return "Agua";
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        $users = User::all();
        $categories = AssetCategory::all();
        $costCenters = CostCenter::all();

        return view('assets.edit', compact('asset', 'users', 'categories', 'costCenters'));
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
        return redirect()->route('assets.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Asset $asset)
    {
        $asset->delete();
        return redirect()->route('assets.index')->with('success', 'Asset deleted successfully.');
    }

    /**
     * Display the dashboard
     */
    public function dashboard()
    {
        $totalAssets = Asset::count();
        $totalCategories = Asset::distinct('category')->count();

        $categories = Asset::select('category')->distinct()->pluck('category');
        $assetsByCategory = Asset::selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category');

        $locations = Asset::select('location')->distinct()->pluck('location');
        $assetsByLocation = Asset::selectRaw('location, COUNT(*) as count')
            ->groupBy('location')
            ->pluck('count', 'location');

        return view('welcome', compact('totalAssets', 'totalCategories', 'categories', 'assetsByCategory', 'locations', 'assetsByLocation'));
    }
}
