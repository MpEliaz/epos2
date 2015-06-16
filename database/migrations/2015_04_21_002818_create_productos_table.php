<?php
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductosTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('productos', function(Blueprint $table)
        {
            $table->increments('id');
            $table->string('nombre');
            $table->string('descripcion_corta');
            $table->string('descripcion');
            $table->integer('id_marca')->unsigned();
            $table->string('modelo');
            $table->integer('numero');
            $table->integer('precio_neto');
            $table->integer('margen');
            $table->integer('precio_venta');
            $table->integer('stock');
            $table->string('codigo');
            $table->boolean('estado');
            $table->integer('id_categoria')->unsigned()->nullable();
            $table->dateTime('fecha_ingreso');
            $table->timestamps();

            $table->foreign('id_marca')->references('id')->on('marcas');
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('productos');
    }
}