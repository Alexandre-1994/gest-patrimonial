<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\CostCenter;
use Illuminate\Database\Seeder;

class CostCenterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $costCenters = [
            [
                'code' => 'ADM001',
                'name' => 'Administração',
                'description' => 'Setor Administrativo'
            ],
            [
                'code' => 'TI002',
                'name' => 'Tecnologia da Informação',
                'description' => 'Departamento de TI'
            ],
            [
                'code' => 'FIN003',
                'name' => 'Financeiro',
                'description' => 'Setor Financeiro'
            ],
            [
                'code' => 'RH004',
                'name' => 'Recursos Humanos',
                'description' => 'Departamento de RH'
            ],
            [
                'code' => 'COM005',
                'name' => 'Comercial',
                'description' => 'Setor Comercial'
            ]
        ];

        foreach ($costCenters as $costCenter) {
            CostCenter::create($costCenter);
        }
    }
}
