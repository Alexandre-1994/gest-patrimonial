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
        Schema::create('related_assets', function (Blueprint $table) {
            // Relacionamentos principais
            $table->id(); // Adicionando ID único para facilitar referências
            $table->foreignId('asset_id')
                ->constrained('assets')
                ->onDelete('restrict');
            // $table->foreignId('related_asset_id')
            //     ->constrained('assets')
            //     ->onDelete('restrict');

            // Tipo de relacionamento
            $table->enum('relationship_type', [
                'parent',           // Ativo pai
                'child',           // Ativo filho
                'component',       // Componente de
                'accessory',      // Acessório de
                'replacement',    // Substituição de
                'dependent',      // Dependente de
                'integrated',     // Integrado com
                'backup',         // Backup de
                'similar'         // Similar a
            ])->index();

            // Detalhes do relacionamento
            $table->text('description')->nullable();
            $table->boolean('is_critical')->default(false);
            $table->boolean('is_bidirectional')->default(false);

            // Datas do relacionamento
            $table->date('start_date');
            $table->date('end_date')->nullable();

            // Status e controle
            $table->enum('status', [
                'active',
                'inactive',
                'pending',
                'archived'
            ])->default('active')->index();

            // Documentação
            $table->string('reference_number')->nullable();
            $table->text('technical_notes')->nullable();

            // Responsáveis
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('restrict');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('restrict');

            // Índices e constraints
            // $table->unique(['asset_id', 'related_asset_id', 'relationship_type']);
            // $table->index(['status', 'is_critical']);

            // Controle de versão
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabela para histórico de relacionamentos
        Schema::create('related_assets_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('related_assets_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('change_type');
            $table->text('change_description');
            $table->json('old_values')->nullable();
            $table->json('new_values');
            $table->foreignId('changed_by')
                ->constrained('users')
                ->onDelete('restrict');
            $table->timestamps();
        });

        // Tabela para documentos do relacionamento
        Schema::create('related_assets_documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('related_assets_id')
                ->constrained()
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
        Schema::dropIfExists('related_assets_documents');
        Schema::dropIfExists('related_assets_history');
        Schema::dropIfExists('related_assets');
    }
};
