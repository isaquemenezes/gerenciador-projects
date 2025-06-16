<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_listar_categorias()
    {
        Category::factory()->count(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertOk()
                 ->assertJsonCount(3);
    }

    public function test_criar_categoria()
    {
        $payload = ['nome' => 'Nova Categoria'];

        $response = $this->postJson('/api/categories', $payload);

        $response->assertCreated()
                 ->assertJsonFragment([
                    'nome' => 'Nova Categoria'
                ]);

        $this->assertDatabaseHas('categories', [
            'nome' => 'Nova Categoria'
        ]);
    }

    public function test_nao_pode_criar_categoria_sem_nome()
    {
        $response = $this->postJson('/api/categories', []);

        $response->assertStatus(422);
    }

    public function test_visualizar_categoria()
    {
        $category = Category::factory()->create();

        $response = $this->getJson("/api/categories/{$category->id}");

        $response->assertOk()
                 ->assertJsonFragment([
                    'id' => $category->id
                ]);
    }

    public function test_nao_encontrar_categoria()
    {
        $response = $this->getJson("/api/categories/9999");

        $response->assertNotFound();
    }

    public function test_atualizar_categoria()
    {
        $category = Category::factory()->create([
            'nome' => 'Antigo'
        ]);

        $payload = ['nome' => 'Atualizado'];

        $response = $this->putJson("/api/categories/{$category->id}", $payload);

        $response->assertOk()
                 ->assertJsonFragment(['nome' => 'Atualizado']);

        $this->assertDatabaseHas('categories', [
            'nome' => 'Atualizado'
        ]);
    }

    public function test_nao_pode_atualizar_categoria_para_nome_existente()
    {
        Category::factory()->create(['nome' => 'Existente']);
        $categoria = Category::factory()->create([
            'nome' => 'Original'
        ]);

        $response = $this->putJson("/api/categories/{$categoria->id}", [
            'nome' => 'Existente'
        ]);

        $response->assertStatus(422);
    }

    public function test_deletar_categoria()
    {
        $category = Category::factory()->create();

        $response = $this->deleteJson("/api/categories/{$category->id}");

        $response->assertNoContent();

        $this->assertDatabaseMissing('categories', [
            'id' => $category->id
        ]);
    }
}
