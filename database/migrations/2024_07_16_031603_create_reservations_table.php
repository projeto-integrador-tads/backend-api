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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id('reservations_id'); // Chave primária, identificador unico da reserva
            $table->foreignId('ride_id')->constrained('rides','ride_id'); //Chave estrangeira, referenciando ride id na tabela Rides.
            $table->foreignId('passenger_id')->constrained('users','id'); //Chave estrangeira, referenciando user id na tabela Users
            $table->dateTime('reservation_time'); //hora da reserva
            $table->string('status',25); //status da reserva 
            $table->string('payment_status',25); //status do pagamento
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
