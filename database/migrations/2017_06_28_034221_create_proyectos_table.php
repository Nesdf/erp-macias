<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProyectosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('proyectos', function (Blueprint $table) {
			$table->increments('id');
			$table->string('titulo_original', 200)->nullable();
			$table->string('titulo_aprobado', 200)->nullable();
			$table->boolean('m_and_e')->nullable();
			$table->integer('statusId')->unsigned();
			$table->integer('clienteId')->unsigned();
			$table->string('titulo_espanol', 200)->nullable();
			$table->string('titulo_ingles', 200)->nullable();
            $table->string('titulo_portugues', 200)->nullable();
            $table->integer('viaId')->nullable();
            $table->string('otro_formato')->nullable();
            $table->text('observaciones')->nullable();
            $table->boolean('dobl_espanol20')->nullable();
            $table->boolean('dobl_espanol51')->nullable();
            $table->boolean('dobl_espanol71')->nullable();
            $table->boolean('dobl_ingles20')->nullable();
            $table->boolean('dobl_ingles51')->nullable();
            $table->boolean('dobl_ingles71')->nullable();
            $table->boolean('dobl_portugues20')->nullable();
            $table->boolean('dobl_portugues51')->nullable();
            $table->boolean('dobl_portugues71')->nullable();
            $table->boolean('subt_espanol')->nullable();
            $table->boolean('subt_ingles')->nullable();
            $table->boolean('subt_portugues')->nullable();
            $table->boolean('material_entregado')->nullable();
            $table->string('temporada', 120)->nullable();
			$table->date('fecha_llegada')->nullable();
			 
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
		Schema::dropIfExists('proyectos');
    }
}
