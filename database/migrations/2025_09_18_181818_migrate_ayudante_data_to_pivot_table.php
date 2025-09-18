<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Migrar datos existentes de ayudante_id a la tabla pivot
        DB::statement('
            INSERT INTO inspection_ayudantes (inspection_id, ayudante_id, created_at, updated_at)
            SELECT id, ayudante_id, created_at, updated_at 
            FROM inspections 
            WHERE ayudante_id IS NOT NULL
        ');

        // Eliminar la columna ayudante_id de la tabla inspections
        Schema::table('inspections', function (Blueprint $table) {
            $table->dropForeign(['ayudante_id']);
            $table->dropColumn('ayudante_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recrear la columna ayudante_id
        Schema::table('inspections', function (Blueprint $table) {
            $table->unsignedBigInteger('ayudante_id')->nullable();
            $table->foreign('ayudante_id')->references('id')->on('users');
        });

        // Migrar datos de vuelta desde la tabla pivot (solo el primer ayudante)
        DB::statement('
            UPDATE inspections 
            SET ayudante_id = (
                SELECT ayudante_id 
                FROM inspection_ayudantes 
                WHERE inspection_ayudantes.inspection_id = inspections.id 
                LIMIT 1
            )
        ');
    }
};
