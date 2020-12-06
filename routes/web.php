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

Route::name('home_dos')->get('/', 'HomeController@index');
Route::name('home')->get('/home', 'HomeController@index_page');
Route::name('categoria')->get('categoria/{slug}/{value}', 'CategoriaController@categoria');
Route::name('vehiculo')->get('vehiculo/{slug}/{value}', 'VehiculoController@vehiculo');
Route::name('vehiculo_recomendacion')->get('vehiculo_recomendacion/{slug}/{value}', 'VehiculoController@vehiculo_recomendacion');
Route::name('vehiculo_buscar')->get('vehiculo_buscar/{slug}/{value}', 'VehiculoController@vehiculo_buscar');
Route::name('vehiculo_inventario')->get('vehiculo_inventario/{slug}/{value}', 'VehiculoController@vehiculo_inventario');
Route::name('vehiculos')->get('vehiculos/publicados', 'VehiculoController@all');
Route::name('autocomplete.ocurrencia')->post('autocomplete', 'AutocompleteController@ocurrencia');

Route::name('buscar.marca')->get('buscar/marca/{slug}/{value}', 'SearchController@marca');
Route::name('buscar.marca_linea')->get('buscar/marca-linea/{slug}/{value}', 'SearchController@marca_linea');
Route::name('buscar.marca_modelo')->get('buscar/marca-modelo/{slug}/{value}', 'SearchController@marca_modelo');
Route::name('buscar.marca_linea_version')->get('buscar/marca-linea-version/{slug}/{value}', 'SearchController@marca_linea_version');
Route::name('buscar.buscador_combo')->post('buscar/marca-linea-precio-min-precio-max', 'SearchController@buscador_combo');

Route::name('buscar.personalizada')->get('busqueda/personalizada', 'SearchController@personalizada');

Route::name('cotizar.store')->post('cotizar', 'Empresa\QuoteController@store');

Route::name('blog.index')->get('blog', 'BlogController@index');
Route::name('blog.seleccionado')->get('blog/{slug}/{value}', 'BlogController@seleccionado');

Route::name('lineas')->get('lineas/{marca}', 'LineaController@lineas');
Route::name('codigos')->get('codigos/{linea}', 'LineaController@codigos');
Route::name('imagenes')->get('imagenes/{codigo}', 'LineaController@imagenes');

Route::name('contacto.index')->get('contacto', 'ContactoController@index');

Route::name('comparar.index')->get('comparar', 'CompararController@index');
Route::name('comparar.store')->post('comparar', 'CompararController@store');
Route::name('comparar.compracion_historica')->get('comparacion/{slug_uno}/v/{comparacion}/s/{slug_dos}', 'CompararController@compracion_historica');

Route::name('quienes_somos.index')->get('quienes_somos', 'QuienesSomosController@index');

Route::name('preguntas_frecuentes.index')->get('preguntas_frecuentes', 'PreguntasFrecuentesController@index');

