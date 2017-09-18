<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEstadosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
		Schema::create('estados', function (Blueprint $table) {
			$table->increments('id');
			$table->string('estado', 30)->unique();
			$table->integer('paisesId')->unsigned();
			$table->timestamps();
			
			$table->foreign('paisesId')
				  ->references('id')->on('paises')
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
		Schema::dropIfExists('estados');
    }
}
