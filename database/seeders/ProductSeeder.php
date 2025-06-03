<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::pluck('id')->toArray();
        $brands = Brand::pluck('id')->toArray();

        // Lista de imágenes disponibles en storage/app/public/products/
        $images = [
            'p1.png', 'p2.png', 'p3.png', 'p4.png', 'p5.png', 'p6.png', 'p7.png', 'p8.png', 'p9.png', 'p10.png',
            'p11.png', 'p12.png', 'p13.png', 'p14.png', 'p15.png', 'p16.png', 'p17.png', 'p18.png', 'p19.png', 'p20.png',
            'p21.png', 'p22.png', 'p23.png', 'p24.png', 'p25.png', 'p26.png', 'p27.png', 'p28.png', 'p29.png', 'p30.png',
            'p31.png'
        ];

        for ($i = 0; $i < 1000; $i++) {
            $name = fake()->unique()->words(3, true); // Nombre más corto para evitar slugs muy largos
            $price = fake()->randomFloat(2, 5, 500); // Precio entre 5 y 500

            Product::create([
                'category_id' => fake()->randomElement($categories), // Asigna una categoría aleatoria
                'brand_id' => fake()->randomElement($brands), // Asigna una marca aleatoria
                'name' => ucfirst($name),
                'slug' => Str::slug($name . '-' . $i), // Evita duplicados
                'description' => fake()->paragraph(),
                'price' => $price, // Precio principal
                'price2' => max($price - 1, 1), // Evita valores negativos en price2
                'stock' => fake()->numberBetween(100, 1000), // Stock entre 100 y 1000
                'image' => 'products/' . fake()->randomElement($images), // Asigna una imagen aleatoria
                'status' => fake()->randomElement(['active', 'inactive']),
            ]);
        }
    }
}
