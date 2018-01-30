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
            $table->string('credencial', 10);
            $table->string('loops', 10);
            $table->string('pago_total_loops', 30);
            $table->string('sala', 50);
            $table->string('director', 255);
            $table->string('folio', 20);
            $table->string('capitulo', 20);
            $table->dateTime('cita_start');
            $table->dateTime('cita_end');
            $table->boolean('estatus_grupo');//Permite ingresar otros actores en el mismo horario
            $table->text('descripcion');
            $table->boolean('estatus');
            $table->string('id_llamado_reagendado', 10);
            $table->string('estatus_llamado', 30);//Permite identificar si el llamados fue reagendado
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
