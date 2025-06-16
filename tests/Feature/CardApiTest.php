<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\Card;
use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CardApiTest extends TestCase
{

    use RefreshDatabase;

    public function test_usuario_pode_listar_cards()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create([
            'user_id' => $user->id
        ]);
        $category = Category::factory()->create();

        Card::factory()->count(3)->create([
            'board_id' => $board->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)->getJson('/api/cards');

        $response->assertOk()
                 ->assertJsonCount(3);
    }

    public function test_usuario_pode_criar_card()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create([
            'user_id' => $user->id
        ]);
        $category = Category::factory()->create();

        $payload = [
            'titulo' => 'Novo Card',
            'descricao' => 'Descrição aqui',
            'order' => 2,
            'board_id' => $board->id,
            'category_id' => $category->id,
        ];

        $response = $this->actingAs($user)
                        ->postJson('/api/cards', $payload);

        $response->assertCreated()
                ->assertJsonFragment([
                    'titulo' => 'Novo Card'
                ]);
    }

    public function test_usuario_pode_ver_um_card()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create([
            'user_id' => $user->id
        ]);
        $category = Category::factory()->create();

        $card = Card::factory()->create([
            'board_id' => $board->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)
            ->getJson("/api/cards/{$card->id}");

        $response->assertOk()
                 ->assertJsonFragment([
                    'id' => $card->id
                ]);
    }

    public function test_usuario_pode_atualizar_um_card()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create([
            'user_id' => $user->id
        ]);
        $category = Category::factory()->create();

        $card = Card::factory()->create([
            'titulo' => 'Card Original',
            'board_id' => $board->id,
            'category_id' => $category->id,
        ]);

        $payload = [
            'titulo' => 'Card Atualizado'
        ];

        $response = $this->actingAs($user)
                         ->putJson("/api/cards/{$card->id}", $payload);

        $response->assertOk()
                 ->assertJsonFragment([
                    'titulo' => 'Card Atualizado'
                ]);

        $this->assertDatabaseHas('cards', [
            'titulo' => 'Card Atualizado'
        ]);
    }

    public function test_usuario_pode_deletar_card()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create([
            'user_id' => $user->id
        ]);
        $category = Category::factory()->create();

        $card = Card::factory()->create([
            'board_id' => $board->id,
            'category_id' => $category->id,
        ]);

        $response = $this->actingAs($user)
                         ->deleteJson("/api/cards/{$card->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('cards', [
            'id' => $card->id
        ]);
    }
}
