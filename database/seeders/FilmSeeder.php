<?php

namespace Database\Seeders;

use App\Models\Film;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FilmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // pakai faker bawaan laravel
        $faker = \Faker\Factory::create();

        // generate 100 data film
        for ($i = 0; $i < 100; $i++) {
            Film::create([
                'title'       => $faker->unique()->sentence(3), // contoh: "The Last Samurai"
                'description' => $faker->paragraph(3),          // contoh deskripsi film
            ]);
        }
    }
}
