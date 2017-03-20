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

Route::get('/', 'HomeController@index')->name('home');

Route::get('/carrinho', 'HomeController@carrinho')->name('carrinho');

Route::post('/carrinho', 'HomeController@adicionarItem')->name('carrinho');

Route::post('/finalizarCompra', 'HomeController@finalizarCompra')->name('finalizar');

Route::get('/compras', 'HomeController@compras')->name('compras');

Route::get('/cliente', 'HomeController@cliente')->name('cliente');

Route::post('/cliente', 'HomeController@atualizarCliente')->name('atualizarCliente');

Route::post('/editarProduto', 'HomeController@editarProduto')->name('editarProduto');

Route::post('/atualizarProduto', 'HomeController@atualizarProduto')->name('atualizarProduto');

Route::get('/inserirProduto', 'HomeController@inserirProduto')->name('inserirProduto');

Route::delete('/removerProduto/{id}', 'HomeController@removerProduto')->name('removerProduto');

Auth::routes();

Route::get('/logout', function(){
  Auth::logout();
  return redirect('/');
})->name('logout');
