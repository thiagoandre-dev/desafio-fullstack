<?php

namespace Database\Factories;

use App\Models\Nivel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Desenvolvedor>
 */
class DesenvolvedorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('pt_BR');

        return [
            'nivel_id' => Nivel::inRandomOrder()->first()->id ?? Nivel::factory(),
            'nome' => $faker->firstName() . ' ' . $faker->lastName(),
            'sexo' => $faker->randomElement(['M', 'F']),
            'data_nascimento' => $faker->dateTimeBetween('-60 years', '-18 years')->format('Y-m-d'),
            'hobby' => $faker->randomElement([null, implode(', ',
                $faker->randomElements([
                    'Ler',
                    'Viajar',
                    'Correr',
                    'Cozinhar',
                    'Jogar videogame',
                    'Fotografia',
                    'Música',
                    'Esportes',
                    'Artesanato',
                    'Dança',
                    'Caminhadas',
                    'Pesca',
                    'Jardinagem',
                    'Yoga',
                    'Meditação',
                ], $this->faker->numberBetween(1, 3), false)
            )]),
        ];
    }
}
