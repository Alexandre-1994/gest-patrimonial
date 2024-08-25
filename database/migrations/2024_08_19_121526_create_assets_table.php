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
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('serial_number')->unique();
            $table->date('acquisition_date');
            $table->decimal('acquisition_value', 10, 2);
            $table->integer('useful_life');
            $table->string('location');
            $table->string('category');
            $table->string('supplier');
            $table->enum('state', ['in_use', 'stored', 'to_be_scrapped'])->default('stored');
            $table->unsignedBigInteger('user_id')->nullable();
            $table->boolean('is_scrapped')->default(false);
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
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
