<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EpisodioRelacionConfiguracionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('episodio_relacion', function(Blueprint $table){
            $table->increments('id');
            $table->integer('id_episodio');
            $table->integer('id_catalogo_configuracion');

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
        Schema::dropIfExists('episodio_relacion-configuracion');
    }
}
