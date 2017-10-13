<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnProyectTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('proyectos', function(Blueprint $table){
            $table->string('titulo_espanol', 200)->nullable();
            $table->string('titulo_ingles', 200)->nullable();
            $table->string('titulo_portugues')->nullable();
            
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
            //---------Subtitulaje
            $table->boolean('subt_espanol')->nullable();
            $table->boolean('subt_ingles')->nullable();
            $table->boolean('subt_portugues')->nullable();
            $table->boolean('material_entregado')->nullable();
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
