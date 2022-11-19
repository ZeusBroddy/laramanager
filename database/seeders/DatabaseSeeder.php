<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            PathSeeder::class,
            UniversitySeeder::class,
            PlanSeeder::class,
            UserSeeder::class,
            InvoiceSeeder::class,
        ]);
    }
}
