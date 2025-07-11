<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->decimal('iva', 8, 2)->default(0)->after('total_price');
    });

    Schema::table('order_items', function (Blueprint $table) {
        $table->decimal('iva', 8, 2)->default(0)->after('price');
    });
}

public function down(): void
{
    Schema::table('orders', function (Blueprint $table) {
        $table->dropColumn('iva');
    });

    Schema::table('order_items', function (Blueprint $table) {
        $table->dropColumn('iva');
    });
}
};
