<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DeleteColumnEpisodiosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('episodios', function(Blueprint $table){
            $table->dropColumn('titulo_espanol');
			$table->dropColumn('titulo_ingles');
			$table->dropColumn('titulo_portugues');
			
			$table->dropColumn('num_episodio');
			$table->dropColumn('viaId');
			$table->dropColumn('observaciones');
			$table->dropColumn('date_m_and_e');
			
			$table->dropColumn('proyectoId');
			$table->dropColumn('dobl_espanol20');
			$table->dropColumn('dobl_espanol51');
			$table->dropColumn('dobl_espanol71');
			$table->dropColumn('dobl_ingles20');
			$table->dropColumn('dobl_ingles51');
			$table->dropColumn('dobl_ingles71');
			$table->dropColumn('dobl_portugues20');
			$table->dropColumn('dobl_portugues51');
			$table->dropColumn('dobl_portugues71');
			//---------Subtitulaje
			$table->dropColumn('subt_espanol');
			$table->dropColumn('subt_ingles');
			$table->dropColumn('subt_portugues');
			$table->dropColumn('material_calificado');
			$table->dropColumn('material_entregado');
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
    }
}
