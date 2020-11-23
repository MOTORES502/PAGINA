<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::name('home')->get('/', 'HomeController@index');
Route::name('categoria')->get('categoria/{slug}/{value}', 'CategoriaController@categoria');
Route::name('vehiculo')->get('vehiculo/{slug}/{value}', 'VehiculoController@vehiculo');
Route::name('vehiculos')->get('vehiculos/publicados', 'VehiculoController@all');
Route::name('autocomplete.ocurrencia')->post('autocomplete', 'AutocompleteController@ocurrencia');

Route::name('buscar.marca')->get('buscar/marca/{slug}/{value}', 'SearchController@marca');
Route::name('buscar.marca_linea')->get('buscar/marca-linea/{slug}/{value}', 'SearchController@marca_linea');
Route::name('buscar.marca_modelo')->get('buscar/marca-modelo/{slug}/{value}', 'SearchController@marca_modelo');
Route::name('buscar.marca_linea_version')->get('buscar/marca-linea-version/{slug}/{value}', 'SearchController@marca_linea_version');

Route::name('buscar.personalizada')->get('busqueda/personalizada', 'SearchController@personalizada');

Route::name('cotizar.store')->post('cotizar', 'Empresa\QuoteController@store');