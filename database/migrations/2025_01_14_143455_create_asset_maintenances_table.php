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
        Schema::create('asset_maintenances', function (Blueprint $table) {
            // Identificação básica
            $table->id();
            $table->string('maintenance_code')->unique()->index();

            // Relacionamentos
            $table->foreignId('asset_id')
                ->constrained()
                ->onDelete('restrict');

            $table->foreignId('cost_center_id')
                ->constrained('cost_centers')
                ->onDelete('restrict');

            // Tipo e classificação
            $table->enum('type', [
                'preventive',
                'corrective',
                'predictive',
                'improvement'
            ])->index();

            $table->enum('priority', [
                'low',
                'medium',
                'high',
                'urgent'
            ])->default('medium');

            // Datas
            $table->date('scheduled_date');
            $table->date('start_date')->nullable();
            $table->date('completion_date')->nullable();
            $table->integer('estimated_duration_hours');
            $table->integer('actual_duration_hours')->nullable();

            // Detalhes da manutenção
            $table->string('title');
            $table->text('description');
            $table->text('technical_details')->nullable();
            $table->text('resolution_notes')->nullable();

            // Custos
            $table->decimal('estimated_cost', 15, 2);
            $table->decimal('actual_cost', 15, 2)->nullable();
            $table->text('cost_breakdown')->nullable();

            // Prestador de serviço
            // $table->foreignId('service_provider_id')
            //     ->constrained('maintenance_providers')
            //     ->onDelete('restrict');
            // $table->string('technician_name')->nullable();
            // $table->string('service_order_number')->nullable();

            // Status e controle
            $table->enum('status', [
                'planned',
                'scheduled',
                'in_progress',
                'completed',
                'cancelled',
                'postponed'
            ])->default('planned')->index();

            // Responsáveis
            $table->foreignId('requested_by')
                ->constrained('users')
                ->onDelete('restrict');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('restrict');

            // Garantia
            $table->boolean('under_warranty')->default(false);
            $table->date('warranty_end_date')->nullable();

            // Índices compostos
            $table->index(['status', 'scheduled_date']);
            $table->index(['asset_id', 'type']);

            // Controle de versão e exclusão lógica
            $table->softDeletes();
            $table->timestamps();
        });

        // Tabela para peças utilizadas na manutenção
        Schema::create('maintenance_parts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_id')
                ->constrained('asset_maintenances')
                ->onDelete('cascade');
            $table->string('part_name');
            $table->string('part_number')->nullable();
            $table->integer('quantity');
            $table->decimal('unit_cost', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        // Tabela para anexos da manutenção
        Schema::create('maintenance_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('maintenance_id')
                ->constrained('asset_maintenances')
                ->onDelete('cascade');
            $table->string('file_path');
            $table->string('file_type');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenance_attachments');
        Schema::dropIfExists('maintenance_parts');
        Schema::dropIfExists('asset_maintenances');
    }
};
