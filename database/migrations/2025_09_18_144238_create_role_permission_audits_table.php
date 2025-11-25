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
        Schema::create('role_permission_audits', function (Blueprint $table) {
            $table->id();
            $table->string('action'); // created, updated, deleted, assigned, removed
            $table->string('auditable_type'); // Role, Permission, User
            $table->unsignedBigInteger('auditable_id');
            $table->string('event'); // role_created, permission_assigned, etc.
            $table->json('old_values')->nullable();
            $table->json('new_values')->nullable();
            $table->string('description')->nullable();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete(); // quien hizo el cambio
            $table->foreignId('target_user_id')->nullable(); // usuario afectado (para asignaciones)
            $table->string('ip_address')->nullable();
            $table->string('user_agent')->nullable();
            $table->timestamps();

            $table->index(['auditable_type', 'auditable_id']);
            $table->index(['user_id', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permission_audits');
    }
};
