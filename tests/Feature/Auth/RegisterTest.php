<?php

namespace Tests\Feature\Auth;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    public function test_validacao_falha_se_dados_incorretos()
    {
        $response = $this->from('/register')->post('/register', [
            'name' => '',
            'email' => 'email-invalido',
            'password' => '123',

        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors([
            'name',
            'email',
            'password',
        ]);

        $this->assertGuest();
    }

    public function test_nao_permite_registrar_email_duplicado()
    {
        User::factory()->create([
            'email' => 'duplicado@example.com',
        ]);

        $response = $this->from('/register')->post('/register', [
            'name' => 'Novo Usuário',
            'email' => 'duplicado@example.com',
            'password' => 'senha123',

        ]);

        $response->assertRedirect('/register');
        $response->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
