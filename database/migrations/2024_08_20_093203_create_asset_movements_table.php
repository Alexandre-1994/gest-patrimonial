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
        if (!Schema::hasTable('asset_movements')) {
            Schema::create('asset_movements', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('asset_id');
                $table->unsignedBigInteger('from_user_id');
                $table->unsignedBigInteger('to_user_id');
                $table->string('from_location');
                $table->string('to_location');
                $table->text('reason');
                $table->timestamp('movement_date');
                $table->string('status');
                $table->text('notes')->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_movements');
    }
};
