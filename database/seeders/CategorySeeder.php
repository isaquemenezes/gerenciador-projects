<?php

namespace Database\Seeders;

use App\Enums\CategoryEnums;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::insert([
            [
                'nome' => CategoryEnums::A_FAZER->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => CategoryEnums::EM_PROGRESSO->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nome' => CategoryEnums::CONCLUIDO->value,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
