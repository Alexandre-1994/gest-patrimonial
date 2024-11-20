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
        Schema::table('foreign_key', function (Blueprint $table) {

            $table->dropColumn('category');

            $table->foreignId('category_id')
                ->constrained('asset_categories')
                ->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('foreign_key', function (Blueprint $table) {
            $table->string('category')->nullable(); // Restaura a coluna antiga
            $table->dropForeign(['category_id']);
            $table->dropColumn('category_id');
        });
    }
};
