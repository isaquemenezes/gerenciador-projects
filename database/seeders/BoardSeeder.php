<?php

namespace Database\Seeders;

use Doctrine\Inflector\Rules\Word;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Board;
use App\Models\User;
use Faker\Factory as Faker;

class BoardSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        $faker = Faker::create();

        for ($i = 1; $i <= 4; $i++) {
            Board::create([
                'user_id' => User::inRandomOrder()->first()->id,
                "nome" => "Board ". $faker->unique()->word,
            ]);
        }
    }
}
