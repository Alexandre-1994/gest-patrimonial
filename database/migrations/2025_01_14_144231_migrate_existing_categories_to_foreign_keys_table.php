<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Pega todos os assets com categoria em string
        $assets = DB::table('assets')->get();

        foreach ($assets as $asset) {
            // Procura ou cria a categoria
            $category = DB::table('asset_categories')
                ->firstOrCreate(
                    ['name' => $asset->category],
                    ['description' => 'Migrated category']
                );

            // Atualiza o asset com o id da categoria
            DB::table('assets')
                ->where('id', $asset->id)
                ->update(['category_id' => $category->id]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foreign_keys', function (Blueprint $table) {
            //
        });
    }
};
