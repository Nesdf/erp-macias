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
			$table->string('razon_social', 100)->unique();
            $table->string('rfc', 15)->unsigned();
			$table->integer('paisId')->unsigned();
			$table->integer('estadoId')->unsigned();
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
		Schema::dropIfExists('clientes');
    }
}
