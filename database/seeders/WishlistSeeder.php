<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Product;
use App\Models\Wishlist;

class WishlistSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'customer')->get();
        $products = Product::pluck('id')->toArray();

        foreach ($users as $user) {
            $numWishlists = fake()->numberBetween(5, 10); // Cada usuario tendrá entre 5 y 10 productos en su lista

            for ($i = 0; $i < $numWishlists; $i++) {
                Wishlist::create([
                    'user_id' => $user->id,
                    'product_id' => fake()->randomElement($products),
                ]);
            }
        }
    }
}
