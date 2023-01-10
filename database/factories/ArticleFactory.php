<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ArticleFactory extends Factory
{
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(5),
            'content' => $this->faker->sentence(10),
        ];
    }
}
