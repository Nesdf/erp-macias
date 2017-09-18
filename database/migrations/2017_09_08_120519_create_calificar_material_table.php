<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalificarMaterialTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('calificar_materiales', function(Blueprint $table){
            $table->increments('id');
            $table->string('correo_activo', 100);
            $table->string('duracion', 25);
            $table->string('tipo_reporte', 100);
            $table->string('mezcla', 100);
            $table->integer('tcr');
            $table->integer('id_episodio');
            $table->text('descripcion');
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
        Schema::dropIfExists('calificar_materiales');
    }
}
