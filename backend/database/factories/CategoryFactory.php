<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class CategoryFactory extends Factory
{
    public function definition(): array
    {
        return [
            // 'name' akan diisi dengan satu kata acak.
            'name' => fake()->unique()->word(),
        ];
    }
}
