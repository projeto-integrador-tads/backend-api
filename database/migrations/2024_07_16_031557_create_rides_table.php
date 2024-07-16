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
        Schema::create('rides', function (Blueprint $table) {
            $table->id('ride_id');// id da tabela de corridas
            $table->foreignId('driver_id')->constrained('users','id'); // Chave estrangeira, referenciando user id na tabela Users 
            $table->foreignId('vehicle_id')->constrained('vehicles','vehicle_id'); // Chave estrangeira, referenciando vehicle id na tabela Vehicles.
            $table->string('start_location',255); //local de início da corrida  
            $table->string('end_location',255); // local destino da corrida
            $table->dateTime('start_time', precision: 0); //horário de início da corrida
            $table->dateTime('end_time', precision: 0); //horário do fim da corrida
            $table->decimal('price',10,2); //Preço por passageiro
            $table->string('preferences',300); //Preferências
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rides');
    }
};
