<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Order;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener solo las órdenes cuyo estado es 'paid'
        $orders = Order::where('status', 'paid')->get();

        foreach ($orders as $order) {
            Payment::create([
                'order_id' => $order->id,
                'payment_method' => fake()->randomElement(['paypal', 'stripe', 'Transferencia','Crédito']),
                'amount' => $order->total_price, // El pago debe coincidir con el total de la orden
                'transaction_id' => fake()->uuid(),
                'transaction_json' => json_encode(['status' => 'success', 'transaction_id' => fake()->uuid()]),
                'status' => 'completed',
            ]);
        }
    }
}
