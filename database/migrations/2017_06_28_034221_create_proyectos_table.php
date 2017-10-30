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
            $table->boolean('adr_ingles')->nullable();
            $table->boolean('adr_espanol')->nullable();
            $table->boolean('adr_portugues')->nullable();
            $table->boolean('mix20')->nullable();
            $table->boolean('mix51')->nullable();
            $table->boolean('mix71')->nullable();
            $table->boolean('relleno_mande')->nullable();
            $table->boolean('m_e_20')->nullable();
            $table->boolean('m_e_51')->nullable();
            $table->boolean('m_e_71')->nullable();
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
