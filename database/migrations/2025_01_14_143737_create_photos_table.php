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
        Schema::create('asset_photos', function (Blueprint $table) {
            // Identificação básica
            $table->id();
            $table->string('photo_code')->unique()->index();

            // Relacionamentos
            $table->foreignId('asset_id')
                ->constrained()
                ->onDelete('restrict');

            // Informações do arquivo
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type');
            $table->integer('file_size')->comment('Size in bytes');
            $table->string('mime_type');

            // Metadados da imagem
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->string('resolution')->nullable();

            // Detalhes e classificação
            $table->text('description')->nullable();
            $table->text('tags')->nullable();
            $table->enum('category', [
                'general',
                'condition',
                'damage',
                'maintenance',
                'installation',
                'other'
            ])->default('general');

            // Status e controle
            $table->boolean('is_primary')->default(false);
            $table->boolean('is_public')->default(true);
            $table->enum('status', [
                'active',
                'archived',
                'pending_review',
                'rejected'
            ])->default('active');

            // Data da foto
            $table->date('photo_date');
            $table->string('location_taken')->nullable();

            // Responsáveis
            $table->foreignId('uploaded_by')
                ->constrained('users')
                ->onDelete('restrict');

            $table->foreignId('approved_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('restrict');

            // Índices
            $table->index(['asset_id', 'is_primary']);
            $table->index(['status', 'category']);

            // Controle de versão e exclusão lógica
            $table->softDeletes();
            $table->timestamps();
        });

        // Tabela para versões processadas das fotos
        Schema::create('asset_photo_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')
                ->constrained('asset_photos')
                ->onDelete('cascade');
            $table->enum('version_type', [
                'thumbnail',
                'medium',
                'large',
                'original'
            ]);
            $table->string('file_path');
            $table->integer('width');
            $table->integer('height');
            $table->integer('file_size');
            $table->timestamps();

            // Índice composto
            $table->unique(['photo_id', 'version_type']);
        });

        // Tabela para anotações nas fotos
        Schema::create('asset_photo_annotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('photo_id')
                ->constrained('asset_photos')
                ->onDelete('cascade');
            $table->string('annotation_text');
            $table->json('coordinates')->comment('JSON with x, y coordinates');
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_photo_annotations');
        Schema::dropIfExists('asset_photo_versions');
        Schema::dropIfExists('asset_photos');
    }
};
