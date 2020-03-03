<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TableRechazosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('rechazos', function(Blueprint $table){
            $table->increments('id');
            $table->date('fecha_rechazo');
            $table->date('fecha_original_envio');
            $table->integer('cliente');
            $table->text('titulo_programa');
            $table->integer('temporada');
            $table->integer('numero_episodio');
            $table->string('idioma', 10);
            $table->integer('id_tipo_error');
            $table->integer('id_departamento_responsable');
            $table->integer('id_puesto_responsable');
            $table->string('nombre_responsable', 100);
            $table->text('descripcion_motivo_rechazo');
            $table->string('nivel_gravedad', 20);
            $table->integer('numero_rechazo');
            $table->integer('id_coordinador');
            $table->integer('id_productor');
            $table->integer('id_director');
            $table->integer('id_editor');
            $table->integer('id_regrabador');
            $table->text('observaciones');
            $table->text('tomar_acciones_prevencion');
            $table->text('accion_tomada');
            $table->string('nombre_completo_responsable',100);
            $table->integer('id_episodio_temporada');
            $table->integer('id_numero_episodio');

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
        Schema::dropIfExists('rechazos');
    }
}
