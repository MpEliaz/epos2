<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class CreateVentaTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('ventas', function(Blueprint $table){

            $table->increments('id');
            $table->integer('nro_venta');
            $table->datetime('fecha_venta');
            $table->enum('tipo_pago',['debito','contado','credito','cheque'])->default('debito');
            $table->enum('estado_venta',['finalizado','cancelado','pendiente'])->default('pendiente');
            $table->integer('total_venta');
            $table->integer('id_vendedor')->unsigned()->nullable();
            $table->integer('id_cliente')->unsigned()->nullable();

            $table->foreign('id_vendedor')->references('id')->on('usuarios');


        });


	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('ventas');

	}

}
