<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as Faker;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $faker = Faker::create('pt_BR');
        return [
            'university_id' => $this->faker->randomElement([1, 2, 3, 4, 5, 6, 7]),
            'cpf' => $faker->cpf(false),
            'birth_date' => $this->faker->dateTimeBetween('-24 years', '-18 years'),
            'address' => 'Rua Qualquer Uma, 1154',
            'city' => 'Ministro Andreazza',
            'postal_code' => '76919000',
            'phone_number' => '69' . $faker->cellphone(false, true)
        ];
    }
}
