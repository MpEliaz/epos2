<?php 

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder {

	public function run()
	{
		\DB::table('usuarios')->insert(array(
			'nombres' 	=> 'Elias Enoc',
            'apellidos' => 'Millachine Perez',
			'email' => 'elias@elias.cl',
			'password' => \Hash::make('123'),
            'direccion' => 'Av. Maria 6875',
            'telefono' => '96957739',
            'id_rol' => null
		));
	}
}
