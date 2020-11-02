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
Route::name('autocomplete.ocurrencia')->post('autocomplete', 'AutocompleteController@ocurrencia');


Route::name('buscar.sub_categoria')->get('buscar/sub-categoria/{slug}/{value}', 'SearchController@sub_categoria');
Route::name('buscar.marca')->get('buscar/marca/{slug}/{value}', 'SearchController@marca');
Route::name('buscar.linea')->get('buscar/linea/{slug}/{value}', 'SearchController@linea');
Route::name('buscar.marca_linea')->get('buscar/marca-linea/{slug}/{value}', 'SearchController@marca_linea');
Route::name('buscar.generacion')->get('buscar/generacion/{slug}/{value}', 'SearchController@generacion');
Route::name('buscar.marca_linea_generacion')->get('buscar/marca-linea-generacion/{slug}/{value}', 'SearchController@marca_linea_generacion');
Route::name('buscar.modelo')->get('buscar/modelo/{slug}/{value}', 'SearchController@modelo');
Route::name('buscar.marca_linea_generacion_modelo')->get('buscar/marca-linea-generacion-modelo/{slug}/{value}', 'SearchController@marca_linea_generacion_modelo');
Route::name('buscar.version')->get('buscar/version/{slug}/{value}', 'SearchController@version');
Route::name('buscar.marca_linea_generacion_modelo_version')->get('buscar/marca-linea-generacion-modelo-version/{slug}/{value}', 'SearchController@marca_linea_generacion_modelo_version');
Route::name('buscar.marca_modelo')->get('buscar/marca-modelo/{slug}/{value}', 'SearchController@marca_modelo');
Route::name('buscar.marca_linea_modelo_version')->get('buscar/marca-linea-modelo-version/{slug}/{value}', 'SearchController@marca_linea_modelo_version');
Route::name('buscar.marca_version')->get('buscar/marca-version/{slug}/{value}', 'SearchController@marca_version');
Route::name('buscar.version_modelo')->get('buscar/version-modelo/{slug}/{value}', 'SearchController@version_modelo');
Route::name('buscar.marca_linea_version')->get('buscar/marca-linea-version/{slug}/{value}', 'SearchController@marca_linea_version');
Route::name('buscar.personalizada')->get('busqueda/personalizada', 'SearchController@personalizada');