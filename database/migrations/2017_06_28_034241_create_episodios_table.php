<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEpisodiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('episodios', function (Blueprint $table) {
			$table->increments('id');
			$table->string('titulo_original', 200);
			$table->string('responsable', 200);
			$table->string('productor', 200);
            $table->string('duracion', 15);
            $table->text('configuracion');
            $table->strng('num_episodio');
			$table->date('date_entrega');
            $table->integer('salaId');
            $table->integer('proyectoId');
            $table->date('date_m_and_e');
			$table->integer('traductorId');
			$table->date('fecha_asignacion_traductor');
			$table->date('fecha_entrega_traductor');
            $table->boolean('script');
            $table->boolean('material_calificado');
			$table->boolean('status_coordinador');//True si ya asignó al traductor
			$table->boolean('validador_traductor'); //True cuando si el Traductor valido la información
			$table->timestamps();         
			
			/*$table->foreign('viaId')
				  ->references('id')->on('vias')
				  ->onDelete('cascade');*/
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
		Schema::dropIfExists('episodios');
    }
}
