<?php

use Illuminate\Database\Seeder;

class MarcaTableSeeder extends Seeder {

    public function run()
    {
        \DB::table('marcas')->insert(array(
            'nombre' => 'Nike'
        ));
    }
}