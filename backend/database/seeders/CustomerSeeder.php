<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cliente;
use App\Models\Cidade;
use App\Models\City;
use App\Models\Customers;
use Faker\Factory as Faker;

class CustomerSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('pt_BR');
        $cidadeIds = City::pluck('id')->toArray();

        for ($i = 0; $i < 10; $i++) {
            Customers::create([
                'name' => $faker->name,
                'url_perfil' => $faker->imageUrl(200, 200, 'people'),
                'cpf' => $faker->unique()->cpf(false),
                'email' => $faker->unique()->email,
                'birth_date' => $faker->date(),
                'city_id' => $faker->randomElement($cidadeIds),
            ]);
        }
    }
}
