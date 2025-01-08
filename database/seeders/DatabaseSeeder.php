<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Models\Tool;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'name' => 'Inspector',
            'email' => 'inspector@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        User::create([
            'name' => 'Ayudante 1',
            'email' => 'ayudante1@admin.com',
            'password' => bcrypt('12345678'),
        ]);
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        Tool::create([
            'name' => 'Taladro',
            'cant' => 1,
            'description' => 'Taladro de 1/2 pulgada',
            'status' => 'Disponible',
            'type' => 'Herramienta',
        ]);
    }
}
