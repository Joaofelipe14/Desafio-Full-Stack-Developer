<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            StateSeeder::class,
            CitySeeder::class,
            ClientSeeder::class,
        ]);

        
        User::factory()->create([
            'name' => 'João',
            'email' => 'admin@com',
            'password' => bcrypt('admin1234'),
        ]);
        
    }
}
