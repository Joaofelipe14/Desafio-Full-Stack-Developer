<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\State;

class CitySeeder extends Seeder
{
    public function run()
    {
        $capitais = [
            ['name' => 'Rio Branco', 'uf' => 'AC'],
            ['name' => 'Maceió', 'uf' => 'AL'],
            ['name' => 'Macapá', 'uf' => 'AP'],
            ['name' => 'Manaus', 'uf' => 'AM'],
            ['name' => 'Salvador', 'uf' => 'BA'],
            ['name' => 'Fortaleza', 'uf' => 'CE'],
            ['name' => 'Brasília', 'uf' => 'DF'],
            ['name' => 'Vitória', 'uf' => 'ES'],
            ['name' => 'Goiânia', 'uf' => 'GO'],
            ['name' => 'São Luís', 'uf' => 'MA'],
            ['name' => 'Cuiabá', 'uf' => 'MT'],
            ['name' => 'Campo Grande', 'uf' => 'MS'],
            ['name' => 'Belo Horizonte', 'uf' => 'MG'],
            ['name' => 'Belém', 'uf' => 'PA'],
            ['name' => 'João Pessoa', 'uf' => 'PB'],
            ['name' => 'Curitiba', 'uf' => 'PR'],
            ['name' => 'Recife', 'uf' => 'PE'],
            ['name' => 'Teresina', 'uf' => 'PI'],
            ['name' => 'Rio de Janeiro', 'uf' => 'RJ'],
            ['name' => 'Natal', 'uf' => 'RN'],
            ['name' => 'Porto Alegre', 'uf' => 'RS'],
            ['name' => 'Porto Velho', 'uf' => 'RO'],
            ['name' => 'Boa Vista', 'uf' => 'RR'],
            ['name' => 'Florianópolis', 'uf' => 'SC'],
            ['name' => 'São Paulo', 'uf' => 'SP'],
            ['name' => 'Aracaju', 'uf' => 'SE'],
            ['name' => 'Palmas', 'uf' => 'TO']
        ];

        foreach ($capitais as $capital) {
            $estado = State::where('uf', $capital['uf'])->first();
            if ($estado) {
                City::create([
                    'name' => $capital['name'],
                    'state_id' => $estado->id
                ]);
            }
        }
    }
}
