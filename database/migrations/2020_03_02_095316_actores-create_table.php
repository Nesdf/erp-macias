<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ActoresCreateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('actores', function(Blueprint $table){
            $table->increments('id');
            $table->string('nombre_completo', 150);
            $table->string('nombre_artistico', 50);
            $table->string('rfc', 16);
            $table->string('cuenta_bancaria', 20);
            $table->string('banco', 30);
            $table->string('clabe', 30);
            $table->string('email', 50);

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
        Schema::dropIfExists('actores');
    }
}
