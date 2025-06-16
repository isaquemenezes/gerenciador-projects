<?php

namespace Tests\Feature;

use App\Models\Board;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BoardApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_usuario_autenticado_pode_listar_boards()
    {
        $user = User::factory()->create();
        Board::factory()->count(3)->create([
            'user_id' => $user->id
        ]);

        $this->actingAs($user)
            ->getJson('/api/boards')
            ->assertOk()
            ->assertJsonCount(3);
    }

    public function test_usuario_autenticado_pode_criar_board()
    {
        $user = User::factory()->create();

        $payload = [
            'nome' => 'Meu novo board'
        ];

        $response = $this->actingAs($user)
            ->postJson('/api/boards', $payload);

        $response->assertCreated()
                 ->assertJsonFragment([
                    'nome' => 'Meu novo board'
                ]);

        $this->assertDatabaseHas('boards', [
            'nome' => 'Meu novo board',
            'user_id' => $user->id,
        ]);
    }

    public function test_nao_pode_criar_board_sem_nome()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->postJson('/api/boards', []);

        $response->assertStatus(422)
                 ->assertJsonValidationErrors(['nome']);
    }

    public function test_usuario_autenticado_pode_atualizar_board()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->putJson("/api/boards/{$board->id}", [
                'nome' => 'Atualizado'
            ]);

        $response->assertOk()
                 ->assertJsonFragment([
                    'nome' => 'Atualizado'
                ]);

        $this->assertDatabaseHas('boards', [
            'id' => $board->id,
            'nome' => 'Atualizado'
        ]);
    }

    public function test_usuario_autenticado_pode_remover_board()
    {
        $user = User::factory()->create();
        $board = Board::factory()->create([
            'user_id' => $user->id
        ]);

        $response = $this->actingAs($user)
            ->deleteJson("/api/boards/{$board->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('boards', [
            'id' => $board->id
        ]);
    }

    public function test_nao_encontra_board_inexistente()
    {
        $user = User::factory()->create();

        $this->actingAs($user)
            ->getJson('/api/boards/999')
            ->assertNotFound()
            ->assertJson([
                'message' => 'Board não encontrado.'
            ]);
    }
}
