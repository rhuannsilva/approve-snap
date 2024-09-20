<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class RequestsUploadsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 4) as $index) {
            DB::table('requests_uploads')->insert([
                'id_request' => $index,
                'id_requesting_user' => '9d0d2c65-838c-432d-a182-89b6710832e5', // ajuste conforme o número de usuários
                'status' => $faker->numberBetween(0, 3), // ajuste conforme os status definidos
                'id_analysis_user' => '9d0d2c65-838c-432d-a182-89b6710832e5', // ajuste conforme o número de usuários
                'observation' => $faker->sentence,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
