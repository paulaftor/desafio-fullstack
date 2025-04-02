<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 0; $i < 10; $i++) {
            User::create([
                'nome' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'senha' => Hash::make('password'), 
                'cpf' => $faker->numerify('###########'),
                'data_nascimento' => $faker->date('Y-m-d', '2000-01-01'),
                'telefone' => $faker->numerify('##########'),
                'logradouro' => $faker->streetAddress,
                'numero' => $faker->buildingNumber,
                'bairro' => $faker->word,
                'cidade' => $faker->city,
                'estado' => $faker->stateAbbr,
                'cep' => $faker->numerify('########'),
                'parentesco' => $faker->word, 
                'email_verified_at' => now(),
            ]);
        }
    }
}
