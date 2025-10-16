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
        Schema::create('alquilers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('bicycle_id')->constrained('bicycles')->cascadeOnDelete();
            $table->foreignId('direccion_id')->constrained('direcciones')->cascadeOnDelete();
            $table->date('start_time');
            $table->date('end_time');
            $table->float('valor_principal');
            $table->float('valor_adicional');
            $table->float('valor_total');
            $table->string('metodo_pago');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquilers');
    }
};
