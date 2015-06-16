<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('usuarios', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('nombres');
            $table->string('apellidos');
			$table->string('email')->unique();
			$table->string('password', 60);
            $table->string('direccion');
            $table->string('telefono');
            $table->boolean('estado')->default(true);
            $table->integer('id_rol')->unsigned()->nullable();
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
		Schema::drop('usuarios');
	}

}
