<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Order;
use App\Models\User;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::where('role', 'customer')->pluck('id')->toArray();

        for ($i = 0; $i < 100; $i++) {
            Order::create([
                'user_id' => fake()->randomElement($users),
                'total_price' => 0, // Se actualizará después al sumar los detalles
                'status' => fake()->randomElement(['pending', 'paid', 'shipped', 'cancelled']),
            ]);
        }
    }
}
