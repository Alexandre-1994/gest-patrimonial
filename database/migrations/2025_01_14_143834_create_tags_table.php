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
        Schema::create('asset_tags', function (Blueprint $table) {
            // Identificação básica
            $table->id();
            $table->string('name')->unique()->index();
            $table->string('slug')->unique()->index();

            // Detalhes da tag
            $table->text('description')->nullable();
            $table->string('color_code')->nullable();
            $table->string('icon')->nullable();

            // Categorização
            $table->enum('type', [
                'status',
                'condition',
                'location',
                'department',
                'project',
                'custom'
            ])->default('custom')->index();

            // Controle
            $table->boolean('is_system')->default(false);
            $table->boolean('is_active')->default(true);
            $table->integer('usage_count')->default(0);

            // Metadados
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('restrict');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('restrict');

            // Controle de versão e exclusão lógica
            $table->softDeletes();
            $table->timestamps();
        });

        // Tabela pivot para relacionamento many-to-many entre assets e tags
        Schema::create('asset_tag_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('asset_id')
                ->constrained()
                ->onDelete('cascade');
            $table->foreignId('tag_id')
                ->constrained('asset_tags')
                ->onDelete('cascade');
            $table->foreignId('tagged_by')
                ->constrained('users')
                ->onDelete('restrict');
            $table->text('note')->nullable();
            $table->timestamps();

            // Garante que um asset não tenha a mesma tag múltiplas vezes
            $table->unique(['asset_id', 'tag_id']);
        });

        // Tabela para grupos de tags
        Schema::create('tag_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        // Tabela pivot para relacionamento entre tags e grupos
        Schema::create('tag_group_relations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tag_id')
                ->constrained('asset_tags')
                ->onDelete('cascade');
            $table->foreignId('group_id')
                ->constrained('tag_groups')
                ->onDelete('cascade');
            $table->timestamps();

            // Garante que uma tag não esteja no mesmo grupo múltiplas vezes
            $table->unique(['tag_id', 'group_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tag_group_relations');
        Schema::dropIfExists('tag_groups');
        Schema::dropIfExists('asset_tag_relations');
        Schema::dropIfExists('asset_tags');
    }
};
