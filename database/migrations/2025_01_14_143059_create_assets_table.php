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
        Schema::create('assets', function (Blueprint $table) {
            // Chave primária e identificadores únicos
            $table->id();
            $table->string('code')->unique()->index();
            $table->string('name');
            $table->text('description')->nullable();

            // Chaves estrangeiras
            $table->foreignId('category_id')
                ->constrained('asset_categories')
                ->onDelete('restrict');

            $table->foreignId('cost_center_id')
                ->constrained('cost_centers')
                ->onDelete('restrict');

            // Informações básicas do ativo
            $table->string('location')->index();
            $table->string('serial_number')->nullable()->index();
            $table->string('brand')->nullable();
            $table->string('model')->nullable();

            // Dados financeiros
            $table->decimal('purchase_value', 15, 2);
            $table->date('purchase_date');
            $table->decimal('current_value', 15, 2);
            $table->decimal('depreciation_rate', 5, 2);
            $table->decimal('maintenance_cost_total', 15, 2)
                ->default(0);

            // Informações técnicas
            $table->text('technical_specifications')->nullable();
            $table->enum('conservation_status', [
                'excellent',
                'good',
                'regular',
                'poor'
            ])->index();

            $table->integer('life_span_months');
            $table->date('warranty_start')->nullable();
            $table->date('warranty_end')->nullable();

            // Controle operacional
            $table->enum('status', [
                'active',
                'inactive',
                'maintenance',
                'disposed'
            ])->index();

            $table->foreignId('responsible_user_id')
                ->constrained('users')
                ->onDelete('restrict');

            $table->enum('criticality_level', [
                'low',
                'medium',
                'high',
                'critical'
            ])->index();

            // Adiciona checks para validação de dados
            // $table->check('purchase_value >= 0');
            // $table->check('current_value >= 0');
            // $table->check('depreciation_rate >= 0');
            // $table->check('maintenance_cost_total >= 0');

            // Índice composto para buscas comuns
            $table->index(['status', 'conservation_status']);
            $table->index(['brand', 'model']);

            // Controle de versão e exclusão lógica
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
