<?php

use Illuminate\Database\Seeder;

class DescuentoTableSeeder extends Seeder {

    public function run()
    {
        \DB::table('descuentos')->insert(array(
            'codigo_descuento' => 'QWERTY123',
            'titulo' => 'Descuento Navidad 15%',
            'descripcion' => 'descuento de 15% en todos los productos con cualquier medio de pago',
            'descuento' => '15',
            'estado' => 1
        ));
    }
}