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
        Schema::create('inspections', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')->nullable()->constrained();
            $table->unsignedBigInteger('ayudante_id')->nullable();
            $table->foreign('ayudante_id')->references('id')->on('users');
            $table->string('solicitante');
            $table->integer('consecutive');
            $table->string('gerencia');
            $table->date('fecha');
            $table->string('tipo');
            $table->string('grafo');
            $table->string('supervisor');
            $table->integer('prioridad'); // 1, 2, 3, 4 , 5
            $table->text('descripcion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspections');
    }
};
