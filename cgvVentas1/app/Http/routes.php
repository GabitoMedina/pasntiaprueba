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

Route::get('/', function () {
    return view('auth/login');
});
/* Route::get('prf', function () {
    return view('proformas.index');
});
Route::get('prfc', function () {
    return view('proformas.create');
}); */

Route::resource('cgv/categoria','CategoriaController');
Route::resource('cgv/articulo','ArticuloController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('compras/proveedor','ProveedorController');
Route::resource('compras/ingreso','IngresoController');
Route::resource('ventas/venta','VentaController');
Route::resource('ventas/servicio','ServicioController');
Route::resource('proformas','ProformaController');
Route::resource('seguridad/usuario','UsuarioController');
Route::get('descargar-productos', 'IngresoController@pdf')->name('compras.ingreso.pdf');



Route::auth();

Route::get('/home', 'HomeController@index');
Route::get('/{slug?}','HomeController@index');
