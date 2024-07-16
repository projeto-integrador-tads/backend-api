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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id('vehicle_id'); // id da tabela 
            $table->foreignId('usercar_id')->constrained('users','id'); //Chave estrangeira, referenciando user id na tabela Users
            $table->string('brand',100); // Marca do veıculo
            $table->string('model',100); // Modelo do veıculo
            $table->year('year')->default('2024'); // Ano de fabricação do veículo
            $table->string('license_plate',100); // Placa do veículo
            $table->string('color',100); // cor do veículo
            $table->integer('seats'); // Número de assentos disponíveis
            $table->string('document',255); //Caminho para o documento comprovativo (ex.CRLV)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
