<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClientesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('clientes', function (Blueprint $table) {
            $table->increments('id');
			$table->string('razon_social')->unique();
            $table->string('rfc')->unique();
			$table->integer('paisId')->unsigned();
			$table->integer('estadoId')->unsigned();
            $table->timestamps();
			$table->foreign('paisId')
				  ->references('id')->on('paises')
				  ->onDelete('cascade');
			$table->foreign('estadoId')
				  ->references('id')->on('estados')
				  ->onDelete('cascade');
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
		Schema::dropIfExists('clientes');
    }
}
