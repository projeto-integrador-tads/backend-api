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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id('review_id');//chave primária
            $table->foreignId('ride_id')->constrained('rides','ride_id'); //Chave estrangeira, referenciando ride id na tabela Rides.
            $table->foreignId('reviewer_id')->constrained('users','id'); //Chave estrangeira, referenciando user id na tabela Users  
            $table->foreignId('reviwee_id')->constrained('users','id'); //Chave estrangeira, referenciando user id na tabela Users.
            $table->integer('rating'); //avaliação
            $table->text('comment'); //comentário
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
