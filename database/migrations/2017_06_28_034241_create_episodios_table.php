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
            $table->integer('directorId')->nullable();
            $table->integer('productor')->nullable();
            $table->integer('responsable')->nullable();
            $table->boolean('validador_traductor')->nullable(); //True cuando si el Traductor valida la información
            $table->date('fecha_asignacion_traductor')->nullable();
            $table->date('fecha_doblaje')->nullable();
            $table->text('quien_modifico_productor')->nullable();
            $table->text('quien_modifico_traductor')->nullable();
            $table->date('fecha_entrega_traductor')->nullable();
            $table->date('fecha_erayado')->nullable();
            $table->date('fecha_aprobacion_cliente')->nullable();
            $table->date('fecha_rayado')->nullable();
            $table->date('fecha_script')->nullable();
			$table->boolean('sin_script')->nullable();
            $table->boolean('aprobacion_cliente')->nullable();
            $table->boolean('rayado')->nullable();
            $table->boolean('status_coordinador')->nullable();//True si ya asignó al traductor
            $table->integer('traductorId')->nullable();
            $table->string('num_episodio')->nullable();
            $table->integer('proyectoId');
            $table->date('date_m_and_e')->nullable();
            $table->boolean('material_calificado')->nullable();
            // $table->boolean('bw')->nullable();
            // $table->boolean('netcut')->nullable();
            // $table->boolean('lockcut')->nullable();
            // $table->boolean('final')->nullable();
            // $table->date('date_bw')->nullable();
            // $table->date('date_netcut')->nullable();
            // $table->date('date_lockcut')->nullable();
            // $table->date('date_final')->nullable();
            $table->text('configuracion')->nullable();
            $table->string('folio');
            //Se agregan en productor y traductor
            $table->boolean('chk_canciones')->nullable();
            $table->boolean('chk_subtitulos')->nullable();
            $table->boolean('chk_lenguaje_diferente_original')->nullable();
            $table->boolean('chk_qc')->nullable();
            $table->boolean('chk_reprobacion')->nullable();
            $table->boolean('chk_edicion')->nullable();
            $table->boolean('notify_pistas')->nullable();
            $table->boolean('send_sebastians')->nullable();
            $table->boolean('ot')->nullable();
            $table->date('fecha_edicion')->nullable();
            $table->date('fecha_qc')->nullable();
            $table->date('date_download')->nullable();
            $table->date('script_original')->nullable();
            $table->date('envio_mp4')->nullable();
            $table->date('send_date_subtitle_transfer')->nullable();
            $table->date('date_boarding')->nullable();
            $table->date('send_date_subtitle_miami')->nullable();
            $table->integer('nombre_regrabador')->nullable();
            $table->integer('nombre_editor')->nullable();
            $table->integer('nombre_qc')->nullable();
            $table->date('fecha_regrabacion')->nullable();
            $table->text('observaciones_traductor')->nullable();
            $table->text('observaciones_regrabador')->nullable();
            $table->text('comentarios_observaciones')->nullable();
            $table->text('reference_download')->nullable();
            $table->string('sincronia',10)->nullable();
            $table->string('compresion',5)->nullable();
            $table->string('las_or_lm',150)->nullable();
            $table->string('bpo_or_lm',150)->nullable();
            $table->string('referencia_envio',100)->nullable();
            $table->string('enviado_a',100)->nullable();
            $table->string('metodo_envio',100)->nullable();
            $table->integer('ingeniero_audio_id')->nullable();
            $table->integer('tipo_trabajo_id')->nullable();
            $table->char('hiss', 2)->nullable();
            $table->boolean('delete_episodio')->default(false);
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
