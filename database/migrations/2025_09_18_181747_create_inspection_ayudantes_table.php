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
        Schema::create('inspection_ayudantes', function (Blueprint $table) {
            $table->id();
            $table->string('inspection_id');
            $table->foreignId('ayudante_id');
            $table->timestamps();
            $table->unique(['inspection_id', 'ayudante_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inspection_ayudantes');
    }
};
