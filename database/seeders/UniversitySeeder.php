<?php

namespace Database\Seeders;

use App\Models\University;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UniversitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $universities = [
            [
                'path_id' => 1,
                'name' => 'FANORTE',
                'avatar' => 'universities/2oAx5yyVitDYe4kA013CPuXurcdnAsrQ04I235We.png',
                'address' => 'Rua Anísio Serrão, 2325',
                'district' => 'Centro',
                'city' => 'Cacoal'
            ],
            [
                'path_id' => 1,
                'name' => 'FACIMED - Sede',
                'avatar' => 'universities/rhRZwp0eWSpUwoNLMrxR8twCjWyRcXGk9k4PMTh6.png',
                'address' => 'Av. Cuiabá, 3087',
                'district' => 'Jardim Clodoaldo',
                'city' => 'Cacoal'
            ],
            [
                'path_id' => 1,
                'name' => 'CETEC',
                'avatar' => 'universities/hTmQMtsg0oSkPe5hcBO0PPCZFOD5H3Rz6sF0VPPY.png',
                'address' => 'Av. Belo Horizonte, 3196',
                'district' => 'Jardim Clodoaldo',
                'city' => 'Cacoal'
            ],
            [
                'path_id' => 1,
                'name' => 'UNIR',
                'avatar' => 'universities/5tXk6EqW1WGX0Lr9uZ2ATjUATRVKyR8NkvkgFYOB.jpg',
                'address' => 'Rua Manoel Vitor Diniz, 2380',
                'district' => 'Jardim São Pedro II',
                'city' => 'Cacoal'
            ],

            [
                'path_id' => 2,
                'name' => 'UNESC',
                'avatar' => 'universities/DQtL3HDybvtiKJFRYk7KcgpjuKP3KX9w96maiXDP.png',
                'address' => 'Rua dos Esportes, 1038',
                'district' => 'Incra',
                'city' => 'Cacoal'
            ],
            [
                'path_id' => 2,
                'name' => 'FACIMED - Unidade 1',
                'avatar' => 'universities/rhRZwp0eWSpUwoNLMrxR8twCjWyRcXGk9k4PMTh6.png',
                'address' => 'Av. Rosilene Transpadini, 2070',
                'district' => 'Jardim Eldorado',
                'city' => 'Cacoal'
            ],
            [
                'path_id' => 2,
                'name' => 'IFRO',
                'avatar' => 'universities/EKWUYxuHOUgNuhSM6fgLLcfY6XC6AdbMwP4ENGMa.png',
                'address' => 'Km 228, Lote 2A, BR-364',
                'district' => 'Zona Rural',
                'city' => 'Cacoal'
            ],
        ];

        foreach ($universities as $university) {
            University::create($university);
        }
    }
}
