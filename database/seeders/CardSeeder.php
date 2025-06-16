<?php

namespace Database\Seeders;

use App\Models\Board;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Card;
use App\Models\Category;
use App\Models\Column;

class CardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $categories = Category::all()->keyBy('nome');

        $cards = [
            [
                'titulo' => 'Criar estrutura Laravel',
                'descricao' => 'Iniciar projeto com Laravel e PostgreSQL',
                'category_nome' => 'A Fazer',
            ],
            [
                'titulo' => 'Criar modelo Board',
                'descricao' => 'Model e migration para Boards',
                'category_nome' => 'Em Progresso',
            ],
            [
                'titulo' => 'Definir rotas da API',
                'descricao' => 'API REST com Laravel Resource Controllers',
                'category_nome' => 'Concluído',
            ],
        ];

        foreach ($cards as $cardData) {
            $board = Board::inRandomOrder()->first();

            Card::create([
                'titulo' => $cardData['titulo'],
                'descricao' => $cardData['descricao'],
                'order' => 1,
                'board_id' => $board->id,
                'category_id' => $categories[$cardData['category_nome']]->id,
            ]);
        }
    }
}
