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
        Schema::create('cost_centers', function (Blueprint $table) {
            $table->date('valid_from')->default(now())->change();
            // Identificação básica
            $table->id();
            $table->string('code')->unique()->index();
            $table->string('name');
            $table->text('description')->nullable();

            // Hierarquia e gestão
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('cost_centers')
                ->onDelete('restrict');

            $table->foreignId('manager_id')
                ->constrained('users')
                ->onDelete('restrict');

            $table->foreignId('alternate_manager_id')
                ->nullable()
                ->constrained('users')
                ->onDelete('restrict');

            // Informações financeiras
            $table->decimal('annual_budget', 15, 2)->default(0);
            $table->decimal('current_budget', 15, 2)->default(0);
            $table->decimal('maintenance_budget', 15, 2)->default(0);
            $table->string('currency')->default('MZN');

            // Controle e status
            $table->boolean('active')->default(true);
            $table->date('valid_from');
            $table->date('valid_until')->nullable();
            $table->enum('status', [
                'active',
                'inactive',
                'suspended',
                'closed'
            ])->default('active')->index();

            // Limites e aprovações
            $table->decimal('approval_limit', 15, 2)->nullable();
            $table->boolean('requires_approval')->default(true);

            // Campos de localização
            $table->string('location')->nullable();
            $table->string('department')->nullable();
            $table->string('division')->nullable();

            // Auditoria
            $table->foreignId('created_by')
                ->constrained('users')
                ->onDelete('restrict');

            $table->foreignId('updated_by')
                ->nullable()
                ->constrained('users')
                ->onDelete('restrict');

            // Índices para otimização
            $table->index(['active', 'status']);
            $table->index(['department', 'division']);

            // Controle de versão e exclusão lógica
            $table->softDeletes();
            $table->timestamps();
        });

        // Tabela para orçamentos mensais
        Schema::create('cost_center_budgets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_center_id')
                ->constrained()
                ->onDelete('cascade');
            $table->date('budget_date');
            $table->decimal('planned_amount', 15, 2);
            $table->decimal('actual_amount', 15, 2)->default(0);
            $table->text('notes')->nullable();
            $table->timestamps();

            // Índice composto
            $table->unique(['cost_center_id', 'budget_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    // public function down(): void
    // {
    //     Schema::dropIfExists('cost_centers');
    //     Schema::dropIfExists('cost_center_budgets');
    // }
    public function down()
    {
        Schema::table('cost_centers', function (Blueprint $table) {
            $table->date('valid_from')->nullable(false)->change();
        });
    }
};
