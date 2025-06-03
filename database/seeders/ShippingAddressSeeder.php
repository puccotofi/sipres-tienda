<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\ShippingAddress;
use App\Models\User;

class ShippingAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::all();

        foreach ($users as $user) {
            $numAddresses = fake()->numberBetween(1, 3); // Cada usuario tendrá entre 1 y 3 direcciones

            for ($i = 0; $i < $numAddresses; $i++) {
                ShippingAddress::create([
                    'user_id' => $user->id,
                    'address' => fake()->streetAddress(),
                    'city' => fake()->city(),
                    'state' => fake()->state(),
                    'zip_code' => fake()->postcode(),
                    'country' => fake()->country(),
                ]);
            }
        }
    }
}
