<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;
use App\Models\Review;
use App\Models\User;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'customer')->pluck('id')->toArray();
        $products = Product::all();

        foreach ($products as $product) {
            $numReviews = fake()->numberBetween(10, 20); // Cada producto tendrá entre 10 y 20 reseñas

            for ($i = 0; $i < $numReviews; $i++) {
                Review::create([
                    'user_id' => fake()->randomElement($users),
                    'product_id' => $product->id,
                    'rating' => fake()->numberBetween(1, 5),
                    'comment' => fake()->sentence(),
                ]);
            }
        }
    }
}
