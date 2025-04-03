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

        for ($i = 0; $i < 10; $i++) {
            $address = Address::create([
                'address' => $faker->address,
                'neighborhood' => $faker->streetName,
                'city_id' => $faker->randomElement($cidadeIds),
            ]);

            Clients::create([
                'name' => $faker->name,
                'url_perfil' => $faker->imageUrl(200, 200, 'people'),
                'mobile' => $faker->areaCode() . '9' . $faker->numerify('########'),
                'email' => $faker->unique()->email,
                'birth_date' => $faker->date(),
                'address_id' => $address->id,
            ]);
        }
    }
}
