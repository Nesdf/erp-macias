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
			$table->string('titulo_original', 200)->nullable();
            $table->date('date_entrega')->nullable();
            $table->integer('salaId')->nullable();
            $table->string('productor', 200)->nullable();
            $table->string('responsable', 200)->nullable();
            $table->boolean('validador_traductor')->nullable(); //True cuando si el Traductor valido la información
            $table->date('fecha_asignacion_traductor')->nullable();
            $table->date('fecha_entrega_traductor')->nullable();
			$table->boolean('script')->nullable();
            $table->boolean('rayado')->nullable();
            $table->boolean('status_coordinador')->nullable();//True si ya asignó al traductor
            $table->integer('traductorId')->nullable();
            $table->string('num_episodio')->nullable();
            $table->integer('proyectoId');
            $table->date('date_m_and_e')->nullable();
            $table->boolean('material_calificado')->nullable();
            $table->boolean('bw')->nullable();
            $table->boolean('netcut')->nullable();
            $table->boolean('lockcut')->nullable();
            $table->boolean('final')->nullable();
            $table->date('date_bw')->nullable();
            $table->date('date_netcut')->nullable();
            $table->date('date_lockcut')->nullable();
            $table->date('date_final')->nullable();
            $table->text('configuracion')->nullable();
            $table->string('folio');
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
		Schema::dropIfExists('episodios');
    }
}
