<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTimecodeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('timecode', function(Blueprint $table){
            $table->increments('id');
            $table->date('fecha')->nullable();
            $table->string('timecode', 11);
            $table->string('timecode_final', 11)->nullable();
            $table->text('observaciones')->nullable();
            $table->integer('id_calificar_material')->nullable();
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
        Schema::dropIfExists('timecode');
    }
}
