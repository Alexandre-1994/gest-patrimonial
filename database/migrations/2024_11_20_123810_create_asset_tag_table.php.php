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
        if (!Schema::hasTable('asset_tag')) {
            Schema::create('asset_tag', function (Blueprint $table) {
                $table->foreignId('asset_id')->constrained();
                $table->foreignId('tag_id')->constrained('asset_tags');
                $table->primary(['asset_id', 'tag_id']);
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
