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
            $table->string('titulo_original');
			$table->string('titulo_espanol');
			$table->string('titulo_ingles');
			$table->string('titulo_eportugues');
			$table->string('duracion');
			$table->integer('num_episodio');
			$table->integer('viaId')->unsigned();
			$table->string('otro_formato');
			$table->text('observaciones');
			$table->date('date_m_and_e')->nullable();
			$table->date('date_entrega');
			$table->integer('proyectoId');
			$table->boolean('dobl_espanol20');
			$table->boolean('dobl_espanol51');
			$table->boolean('dobl_espanol71');
			$table->boolean('dobl_ingles20');
			$table->boolean('dobl_ingles51');
			$table->boolean('dobl_ingles71');
			$table->boolean('dobl_portugues20');
			$table->boolean('dobl_portugues51');
			$table->boolean('dobl_portugues71');
			//---------Subtitulaje
			$table->boolean('subt_espanol');
			$table->boolean('subt_ingles');
			$table->boolean('subt_portugues');
			$table->boolean('material_calificado');
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
