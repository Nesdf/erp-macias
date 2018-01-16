<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateActorPersonajeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('actor_personaje', function(Blueprint $table){
            $table->increments('id');
            $table->string('episodio_folio', 10);
            $table->string('personaje');
            $table->boolean('fijo');
            $table->boolean('proyecto');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('actor_personaje');
    }
}
