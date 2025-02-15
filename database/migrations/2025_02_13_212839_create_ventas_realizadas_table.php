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
        Schema::create('ventas_realizadas', function (Blueprint $table) {
            $table->id();
    $table->foreignId('cotizacion_id')->constrained('cotizaciones')->onDelete('cascade');
    $table->foreignId('cliente_id')->constrained('clientes')->onDelete('cascade');
    $table->date('fecha_venta');
    $table->decimal('total', 15, 2);
    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas_realizadas');
    }
};
