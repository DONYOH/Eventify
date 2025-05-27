<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('place_reserves', function (Blueprint $table) {
            $table->id();
            $table->integer('id_client');
            $table->integer('id_event');
            $table->integer('numero_place')->nullable();
            $table->integer('montant_place')->nullable();
            $table->timestamps();
            $table->foreign('id_client')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('id_event')->references('id')->on('evenements')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('place_reserves');
    }
};
