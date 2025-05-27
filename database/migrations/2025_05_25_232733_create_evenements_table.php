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
        Schema::create('evenements', function (Blueprint $table) {
            $table->id();
            $table->string('event_name');
            $table->string('event_description');
            $table->string('pays');
            $table->string('ville');
            $table->string('localisation_maps');
            $table->string('adresse_event');
            $table->integer('idCategorie_event');
            $table->time('heure_event');
            $table->date('date_event');
            $table->integer('status_event')->default(1);
            $table->timestamps();
            $table->foreign('categorie_event_id')->references('id')->on('categorie_events')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('evenements');
    }
};
