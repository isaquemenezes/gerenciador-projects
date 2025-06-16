<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([

                'name' => 'Administrador',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin@123'),
                'is_admin' => true,

        ]);

        // Usuários fictícios em lote
        User::factory()->count(7)->create();
    }
}
