<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cidade;
use App\Models\Estado;

class CidadeSeeder extends Seeder
{
    public function run()
    {
        $capitais = [
            ['nome' => 'Rio Branco', 'sigla' => 'AC'],
            ['nome' => 'Maceió', 'sigla' => 'AL'],
            ['nome' => 'Macapá', 'sigla' => 'AP'],
            ['nome' => 'Manaus', 'sigla' => 'AM'],
            ['nome' => 'Salvador', 'sigla' => 'BA'],
            ['nome' => 'Fortaleza', 'sigla' => 'CE'],
            ['nome' => 'Brasília', 'sigla' => 'DF'],
            ['nome' => 'Vitória', 'sigla' => 'ES'],
            ['nome' => 'Goiânia', 'sigla' => 'GO'],
            ['nome' => 'São Luís', 'sigla' => 'MA'],
            ['nome' => 'Cuiabá', 'sigla' => 'MT'],
            ['nome' => 'Campo Grande', 'sigla' => 'MS'],
            ['nome' => 'Belo Horizonte', 'sigla' => 'MG'],
            ['nome' => 'Belém', 'sigla' => 'PA'],
            ['nome' => 'João Pessoa', 'sigla' => 'PB'],
            ['nome' => 'Curitiba', 'sigla' => 'PR'],
            ['nome' => 'Recife', 'sigla' => 'PE'],
            ['nome' => 'Teresina', 'sigla' => 'PI'],
            ['nome' => 'Rio de Janeiro', 'sigla' => 'RJ'],
            ['nome' => 'Natal', 'sigla' => 'RN'],
            ['nome' => 'Porto Alegre', 'sigla' => 'RS'],
            ['nome' => 'Porto Velho', 'sigla' => 'RO'],
            ['nome' => 'Boa Vista', 'sigla' => 'RR'],
            ['nome' => 'Florianópolis', 'sigla' => 'SC'],
            ['nome' => 'São Paulo', 'sigla' => 'SP'],
            ['nome' => 'Aracaju', 'sigla' => 'SE'],
            ['nome' => 'Palmas', 'sigla' => 'TO']
        ];

        foreach ($capitais as $capital) {
            $estado = Estado::where('sigla', $capital['sigla'])->first();
            if ($estado) {
                Cidade::create([
                    'nome' => $capital['nome'],
                    'estado_id' => $estado->id
                ]);
            }
        }
    }
}
