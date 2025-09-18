<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Asignar el primer proyecto disponible a todas las inspecciones que no tengan project_id
        DB::table('inspections')
            ->whereNull('project_id')
            ->update(['project_id' => 1]); // Asignamos el primer proyecto
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
