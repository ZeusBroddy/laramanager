<?php

namespace Database\Seeders;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
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
        $user = User::create([
            'role' => 'admin',
            'name' => 'admin',
            'email' => 'admin@auma.com',
            'password' => Hash::make('12345678')
        ]);

        $user->profile()->create([
            'university_id' => 5,
            'cpf' => '82302730062',
            'birth_date' => '1996/08/14',
            'address' => 'Rua Qualquer Uma, 1154',
            'city' => 'Ministro Andreazza',
            'postal_code' => '76919000',
            'phone_number' => '69993118491'
        ]);

        User::factory()
            ->has(Profile::factory())
            ->count(20)
            ->create();
    }
}
