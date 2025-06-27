<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        // Elimina la restricción enum si existe y cambia a string
        Schema::table('orders', function (Blueprint $table) {
            // Puedes necesitar usar ->change() si usas MySQL y tienes doctrine/dbal
            $table->string('status', 30)->default('Recibida')->change();
        });
    }

    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            // Si decides revertir, vuelve al enum
            $table->enum('status', [
                'Recibida',
                'Cotizacion',
                'Cotizada',
                'Enviada',
                'Entregada',
                'Pagada',
                'Cerrada'
            ])->default('recibida')->change();
        });
    }
};