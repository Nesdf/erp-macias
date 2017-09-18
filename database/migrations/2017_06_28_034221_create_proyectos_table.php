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
			$table->string('titulo_original', 200);
			$table->string('titulo_aprobado', 200);
			$table->boolean('m_and_e');
			$table->integer('statusId')->unsigned();
			$table->integer('clienteId')->unsigned();
						
			/*$table->foreign('statusId')
		      ->references('id')->on('status')
		      ->onDelete('cascade');
			
			$table->foreign('idiomaId')
				  ->references('id')->on('idiomas')
				  ->onDelete('cascade');
				  
			$table->foreign('clienteId')
		      ->references('id')->on('clientes')
		      ->onDelete('cascade');*/
			 
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
