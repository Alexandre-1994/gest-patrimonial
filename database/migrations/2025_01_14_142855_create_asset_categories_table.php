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
        Schema::create('asset_categories', function (Blueprint $table) {
            // Identificação básica
            $table->id();
            $table->string('code')->unique()->index();
            $table->string('name');
            $table->text('description')->nullable();

            // Hierarquia de categorias
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('asset_categories')
                ->onDelete('restrict');

            // Controles adicionais
            $table->boolean('active')->default(true);
            $table->integer('depreciation_rate')->nullable();
            $table->integer('estimated_life_months')->nullable();

            // Campos para auditoria
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            // Índices para otimização
            $table->index(['active', 'name']);

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
        Schema::dropIfExists('asset_categories');
    }
};
