<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i < 5; $i++) {
            $name = fake()->unique()->word(); // Genera un nombre aleatorio único

            Category::create([
                'name' => ucfirst($name), // Primera letra en mayúscula
                'slug' => Str::slug($name),
                'description' => fake()->sentence(), // Descripción aleatoria
            ]);
        }
    }
}
