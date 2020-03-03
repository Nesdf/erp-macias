<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLlamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('llamado', function(Blueprint $table){
            $table->increments('id');
            $table->string('actor', 255);
            $table->string('director', 255);
            $table->string('folio_id', 10);
            $table->dateTime('cita_start');
            $table->dateTime('cita_end');
            $table->boolean('estatus_grupo');//Permite ingresar otros actores en el mismo horario
            $table->text('descripcion');
            $table->boolean('estatus');
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
        Schema::dropIfExists('llamado');
    }
}
