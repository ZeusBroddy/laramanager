<?php

namespace Database\Seeders;

use App\Models\Path;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PathSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $paths = [
            [
                'name' => 'Rota UNIR',
            ],
            [
                'name' => 'Rota IFRO',
            ],
        ];

        foreach ($paths as $path) {
            Path::create($path);
        }
    }
}
