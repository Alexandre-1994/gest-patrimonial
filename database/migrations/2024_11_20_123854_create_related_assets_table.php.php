<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {

        if (!Schema::hasTable('related_assets')) {
            Schema::create('related_assets', function (Blueprint $table) {
                $table->foreignId('asset_id')->constrained();
                $table->foreignId('related_asset_id')->constrained('assets');
                $table->string('relationship_type');
                $table->text('description')->nullable();
                $table->primary(['asset_id', 'related_asset_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
