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
        if (!Schema::hasTable('asset_photos')) {
            Schema::create('asset_photos', function (Blueprint $table) {
                $table->id();
                $table->foreignId('asset_id')->constrained();
                $table->string('file_path');
                $table->string('description')->nullable();
                $table->boolean('is_primary')->default(false);
                $table->timestamps();
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
