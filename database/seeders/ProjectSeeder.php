<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'BICM - Refinería Barrancabermeja',
                'gerencia' => 'GECON',
                'code_sap' => 'C-19-001',
                'date' => '2025-09-11',
            ],
            [
                'name' => 'Terminal Norte - Ampliación Muelles',
                'gerencia' => 'GEBOC',
                'code_sap' => 'B-20-001',
                'date' => '2025-01-15',
            ],
            [
                'name' => 'Modernización Refinería Cartagena',
                'gerencia' => 'GEMAM',
                'code_sap' => 'M-21-003',
                'date' => '2025-03-20',
            ],
            [
                'name' => 'Infraestructura Digital ECOPETROL',
                'gerencia' => 'GEDIN',
                'code_sap' => 'D-22-005',
                'date' => '2025-05-10',
            ],
            [
                'name' => 'Oleoducto Bicentenario - Fase II',
                'gerencia' => 'GECON',
                'code_sap' => 'C-23-007',
                'date' => '2025-07-15',
            ],
            [
                'name' => 'Terminal Coveñas - Optimización',
                'gerencia' => 'GEBOC',
                'code_sap' => 'B-24-009',
                'date' => '2025-08-20',
            ],
            [
                'name' => 'Planta Polietileno Barrancas',
                'gerencia' => 'GEMAM',
                'code_sap' => 'M-25-011',
                'date' => '2025-09-30',
            ],
        ];

        foreach ($projects as $project) {
            \App\Models\Project::updateOrCreate(
                ['code_sap' => $project['code_sap']],
                $project
            );
        }
    }
}
