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
        if (!Schema::hasTable('assets')) {
            Schema::create('assets', function (Blueprint $table) {
                $table->id();
                $table->string('code')->unique();
                $table->string('name');
                $table->text('description')->nullable();
                $table->foreignId('category_id')->constrained('asset_categories');
                $table->foreignId('cost_center_id')->constrained('cost_centers')->onDelete('restrict'); // Apenas uma vez aqui
                $table->string('location');
                $table->string('serial_number')->nullable();
                $table->string('brand')->nullable();
                $table->string('model')->nullable();

                // Dados financeiros
                $table->decimal('purchase_value', 15, 2);
                $table->date('purchase_date');
                $table->decimal('current_value', 15, 2);
                $table->decimal('depreciation_rate', 5, 2);
                $table->decimal('maintenance_cost_total', 15, 2)->default(0);

                // Informações técnicas
                $table->text('technical_specifications')->nullable();
                $table->enum('conservation_status', ['excellent', 'good', 'regular', 'poor']);
                $table->integer('life_span_months');
                $table->date('warranty_start')->nullable();
                $table->date('warranty_end')->nullable();

                // Controle operacional
                $table->enum('status', ['active', 'inactive', 'maintenance', 'disposed']);
                $table->foreignId('responsible_user_id')->constrained('users');
                $table->enum('criticality_level', ['low', 'medium', 'high', 'critical']);

                $table->softDeletes();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
