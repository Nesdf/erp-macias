<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarLlamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('calendario', function(Blueprint $table){
            $table->increments('id');
            $table->string('actor', 60);
            $table->string('cita_start', 50);
            $table->string('cita_end', 50);
            $table->string('folio', 20);
            $table->string('folio_id', 20)->nullable();
            $table->boolean('estatus_grupo', 50);
            $table->boolean('estatus', 50);
            $table->text('descripcion', 50);
            $table->string('director', 100);
            $table->string('credencial', 10);
            $table->string('loops', 10);
            $table->string('sala', 50);
            $table->string('capitulo', 255);
            $table->string('pago_total_loops', 30);
            $table->string('estatus_llamado', 30);
            $table->string('id_llamado_reagendado', 10)->nullable();
            $table->text('descripcion_reagenda', 10)->nullable();
            $table->string('nombre_real', 255);
            $table->string('estatus_pago', 200);
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
        Schema::dropIfExists('calendario');
    }
}
