<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Cidade;
use Faker\Factory as Faker;

class ClienteSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('pt_BR');
        $cidadeIds = Cidade::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            Cliente::create([
                'nome' => $faker->name,
                'url_perfil' => $faker->imageUrl(200, 200, 'people'),
                'cpf' => $faker->unique()->cpf(false),
                'email' => $faker->unique()->email,
                'data_nascimento' => $faker->date(),
                'cidade_id' => $faker->randomElement($cidadeIds),
            ]);
        }
    }
}
