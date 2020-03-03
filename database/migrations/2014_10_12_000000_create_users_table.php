<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', 50);
            $table->string('ap_paterno', 50);
			$table->string('ap_materno', 50)->unsigned();
            $table->string('email')->unique();
            $table->string('password', 60);
            $table->boolean('tipo_empleado');// 1 = Técnico; 0 = Administrativo
            $table->integer('job');
            $table->text('lista_estudios')->nullable();
            $table->boolean('status_ingreso_sistema')->nullable()->default(false);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
