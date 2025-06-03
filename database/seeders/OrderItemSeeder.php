<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = Order::all();
        $products = Product::pluck('id')->toArray();

        foreach ($orders as $order) {
            $numItems = fake()->numberBetween(5, 10); // Cada orden tendrá entre 1 y 5 productos
            $total = 0;

            for ($i = 0; $i < $numItems; $i++) {
                $productId = fake()->randomElement($products);
                $price = fake()->randomFloat(2, 5, 500);
                $quantity = fake()->numberBetween(1, 3);
                $subtotal = $price * $quantity;
                $total += $subtotal;

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $productId,
                    'quantity' => $quantity,
                    'price' => $price,
                    'subtotal' => $subtotal,
                ]);
            }

            // Actualizar el total de la orden
            $order->update(['total_price' => $total]);
        }
    }
}
