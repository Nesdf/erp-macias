<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendarLlamadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('calendario', function(Blueprint $table){
            $table->increments('id');
            $table->string('actor', 50);
            $table->string('cita_start', 50);
            $table->string('cita_end', 50);
            $table->string('folio_id', 20)->nullable();
            $table->boolean('estatus_grupo', 50);
            $table->boolean('estatus', 50);
            $table->text('descripcion', 50);
            $table->string('director', 50);
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
        Schema::dropIfExists('calendario');
    }
}
