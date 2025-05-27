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
        Schema::create('places', function (Blueprint $table) {
            $table->id();
            $table->integer('id_event');
            $table->integer('id_type_place');
            $table->integer('montant_event');
            $table->integer('status_place')->default(1);
            $table->timestamps();
            $table->foreign('id_event')->references('id')->on('evenements')->onDelete('cascade');
            $table->foreign('id_type_place')->references('id')->on('typeplaces')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('places');
    }
};
