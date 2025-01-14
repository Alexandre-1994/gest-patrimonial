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
        Schema::create('asset_moviments', function (Blueprint $table) {
            // Identificação básica
            $table->id();
            $table->string('movement_code')->unique()->index();

            // Relacionamentos principais
            $table->foreignId('asset_id')
                ->constrained('assets')
                ->onDelete('restrict');

            $table->foreignId('from_user_id')
                ->constrained('users')
                ->onDelete('restrict');

            $table->foreignId('to_user_id')
                ->constrained('users')
                ->onDelete('restrict');

            // Localizações
            $table->string('from_location')->index();
            $table->string('to_location')->index();

            // Centros de custo envolvidos
            $table->foreignId('from_cost_center_id')
                ->constrained('cost_centers')
                ->onDelete('restrict');

            $table->foreignId('to_cost_center_id')
                ->constrained('cost_centers')
                ->onDelete('restrict');

            // Informações da movimentação
            $table->text('reason');
            $table->timestamp('movement_date');
            $table->enum('status', [
                'pending',
                'approved',
                'in_transit',
                'completed',
                'cancelled'
            ])->default('pending')->index();

            // Aprovações
            $table->foreignId('requested_by')
                ->constrained('users')
                ->onDelete('restrict');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('restrict');

            $table->timestamp('approved_at')->nullable();

            // Datas de efetivação
            $table->timestamp('expected_delivery')->nullable();
            $table->timestamp('actual_delivery')->nullable();

            // Campos adicionais
            $table->text('notes')->nullable();
            $table->boolean('requires_installation')->default(false);
            $table->text('installation_notes')->nullable();

            // Campos de controle
            $table->boolean('is_temporary')->default(false);
            $table->timestamp('return_date')->nullable();

            // Índices compostos
            $table->index(['status', 'movement_date']);
            $table->index(['from_user_id', 'to_user_id']);

            // Controle de versão e exclusão lógica
            $table->softDeletes();
            $table->timestamps();
        });

        // Adiciona tabela para documentos da movimentação
        Schema::create('asset_movement_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movement_id')
                ->constrained('asset_moviments')
                ->onDelete('cascade');
            $table->string('document_type');
            $table->string('file_path');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_movement_documents');
        Schema::dropIfExists('asset_movements');
    }
};
