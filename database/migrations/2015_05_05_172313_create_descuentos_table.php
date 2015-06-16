<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDescuentosTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('descuentos', function(Blueprint $table)
		{
			$table->increments('id');
            $table->string('codigo_descuento');
            $table->string('titulo');
            $table->string('descripcion');
            $table->integer('descuento');
            $table->integer('estado');
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
		Schema::drop('descuentos');
	}

}
