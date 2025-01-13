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
        if (!Schema::hasTable('asset_maintenances')) {
            Schema::create('asset_maintenances', function (Blueprint $table) {
                $table->id();
                $table->foreignId('asset_id')->constrained();
                $table->string('type'); // preventiva/corretiva
                $table->date('scheduled_date');
                $table->date('execution_date')->nullable();
                $table->text('description');
                $table->decimal('cost', 15, 2);
                $table->string('service_provider');
                $table->string('status');
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
