<?php

namespace Database\Seeders;

use App\Models\AssetCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AssetCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Equipamentos de TI', 'description' => 'Computadores, notebooks, impressoras'],
            ['name' => 'Móveis', 'description' => 'Mesas, cadeiras, armários'],
            ['name' => 'Veículos', 'description' => 'Carros, motos, caminhões'],
            ['name' => 'Máquinas e Equipamentos', 'description' => 'Equipamentos industriais'],
            ['name' => 'Ferramentas', 'description' => 'Ferramentas manuais e elétricas']
        ];

        foreach ($categories as $category) {
            AssetCategory::create($category);
        }
    }
}
