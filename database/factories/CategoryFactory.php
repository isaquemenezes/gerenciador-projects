<?php

namespace Database\Factories;

use App\Enums\CategoryEnums;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
           'nome' => fake()->unique()->randomElement(CategoryEnums::values()),
        ];
    }
}
