<?php

namespace Database\Seeders;

use App\Models\Plan;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $plans = [
            [
                'name' => 'Plano mensal',
                'description' => 'Default',
                'amount' => 105
            ],
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
