<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['namespace' => 'Api'], function (){
    Route::apiResource('Vendedor', 'VendedorApiController');
    Route::apiResource('Produto', 'ProdutoApiController');
    Route::apiResource('Venda', 'VendaApiController');

    Route::get('Venda/{id}/Produto', 'VendaApiController@Produtos');
    Route::get('Venda/{id}/Vendedor', 'VendaApiController@Vendedores');
    Route::get('Venda/{id}/ProdutoVenda', 'VendaApiController@ProdutoVenda');
    
    Route::get('VendedorVendaProduto', 'VendedorApiController@VendedorVendaProduto');
    Route::get('VendedorVenda/{id}', 'VendaApiController@VendedorVenda');
    
});

