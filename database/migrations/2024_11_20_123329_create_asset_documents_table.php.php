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
        if (!Schema::hasTable('asset_documents')) {
            Schema::create('asset_documents', function (Blueprint $table) {
                $table->id();
                $table->foreignId('asset_id')->constrained();
                $table->enum('type', [
                    'invoice',
                    'warranty',
                    'insurance',
                    'certification',
                    'calibration',
                    'manual',
                    'other'
                ]);
                $table->string('title');
                $table->string('file_path');
                $table->date('expiration_date')->nullable();
                $table->text('description')->nullable();
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
