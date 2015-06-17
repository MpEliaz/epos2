<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


use Carbon\Carbon;
use Epos\Models\Producto;
use Epos\Models\Venta;
use Illuminate\Support\Facades\Input;

use Illuminate\Support\Facades\Route;


Route::get('welcome', 'WelcomeController@index');

Route::get('/', 'VentasController@index');
Route::get('all_ventas', 'VentasController@showVentas');
Route::post('productos/activar', 'ProductosController@activar');
Route::post('productos/desactivar', 'ProductosController@desactivar');
Route::resource('productos', 'ProductosController');
Route::post('descuento/activar', 'DescuentosController@activar');
Route::post('descuento/desactivar', 'DescuentosController@desactivar');
Route::resource('descuentos', 'DescuentosController');
Route::resource('marcas', 'MarcaController');
Route::resource('ventas', 'VentasController');

Route::post('desc_','DescuentosController@get_desc');

Route::controllers([
	'auth' => 'Auth\AuthController',
	'password' => 'Auth\PasswordController',
]);

Route::get('hola',function(){
    $nombre = Input::get('nombre');
    $productos = Producto::where('nombre', 'like', '%'.$nombre.'%')->where('estado','=',true)->where('stock','>', 0)->get();
    //$productos = Producto::all();
    return response()->json($productos);
});


Route::get('search_code', function(){
    $codigo = Input::get('codigo');
    $p = Producto::where('codigo','=',$codigo)->get();

    return response()->json($p);
    });

Route::get('mundo', function(){
    $venta_data = array(
        'nro_venta' 	=> 0,
        'fecha_venta' => Carbon::now(),
        'tipo_pago' => 'contado',
        'estado_venta' => 1,
        'total_venta' => 0,
        'id_vendedor' => null,
        'id_cliente' => null
    );
    $venta = Venta::create($venta_data);

});

