<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class EnderecoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'cep' => $this->faker->numerify('########'),
            'logradouro' => $this->faker->streetName(),
            'bairro' => $this->faker->city(),
            'municipio' => $this->faker->city(),
            'uf' => strtoupper(Str::random(2)),
        ];
    }
}
