<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Cities;
use App\Models\Clients;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create('pt_BR');
        $cidadeIds = Cities::pluck('id')->toArray();

        // Criando 10 registros de clientes
        for ($i = 0; $i < 10; $i++) {
            // Criando um endereço para o cliente
            $address = Address::create([
                'address' => $faker->address,
                'neighborhood' => $faker->streetName,
                'city_id' => $faker->randomElement($cidadeIds),
            ]);

            // Criando o cliente e associando ao endereço
            Clients::create([
                'name' => $faker->name,
                'url_perfil' => $faker->imageUrl(200, 200, 'people'),
                'mobile' => $faker->areaCode() . '9' . $faker->numerify('########'),
                'birth_date' => $faker->date(),
                'address_id' => $address->id,
            ]);
        }
    }
}
