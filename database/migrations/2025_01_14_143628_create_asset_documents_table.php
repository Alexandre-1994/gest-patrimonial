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
        Schema::create('asset_documents', function (Blueprint $table) {
            // Identificação básica
            $table->id();
            $table->string('document_code')->unique()->index();

            // Relacionamentos
            $table->foreignId('asset_id')
                ->constrained()
                ->onDelete('restrict');

            // Classificação do documento
            $table->enum('type', [
                'invoice',
                'warranty',
                'insurance',
                'certification',
                'calibration',
                'manual',
                'maintenance_record',
                'inspection_report',
                'disposal_document',
                'purchase_order',
                'contract',
                'other'
            ])->index();

            // Informações do documento
            $table->string('title');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type');
            $table->integer('file_size')->comment('Size in bytes');
            $table->text('description')->nullable();

            // Datas importantes
            $table->date('document_date');
            $table->date('expiration_date')->nullable();
            $table->date('reminder_date')->nullable();

            // Status e controle
            $table->boolean('is_active')->default(true);
            $table->boolean('requires_renewal')->default(false);
            $table->boolean('is_confidential')->default(false);
            $table->enum('status', [
                'active',
                'expired',
                'pending_renewal',
                'archived'
            ])->default('active')->index();

            // Versão do documento
            $table->string('version')->nullable();
            $table->integer('revision_number')->default(1);

            // Referências externas
            $table->string('reference_number')->nullable();
            $table->string('issuing_authority')->nullable();

            // Responsáveis
            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->onDelete('restrict');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('restrict');

            // Campos de validação
            $table->timestamp('validated_at')->nullable();
            $table->foreignId('validated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('restrict');

            // Índices compostos
            $table->index(['type', 'status']);
            $table->index(['asset_id', 'type']);
            $table->index(['expiration_date', 'status']);

            // Controle de versão e exclusão lógica
            $table->softDeletes();
            $table->timestamps();
        });

        // Tabela para histórico de versões
        Schema::create('asset_document_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')
                ->constrained('asset_documents')
                ->onDelete('cascade');
            $table->string('file_path');
            $table->string('version');
            $table->text('change_notes')->nullable();
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('restrict');
            $table->timestamps();
        });

        // Tabela para compartilhamento de documentos
        Schema::create('asset_document_shares', function (Blueprint $table) {
            $table->id();
            $table->foreignId('document_id')
                ->constrained('asset_documents')
                ->onDelete('cascade');
            $table->foreignId('shared_with')
                ->constrained('users')
                ->onDelete('cascade');
            $table->timestamp('access_until')->nullable();
            $table->boolean('can_download')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_document_shares');
        Schema::dropIfExists('asset_document_versions');
        Schema::dropIfExists('asset_documents');
    }
};
