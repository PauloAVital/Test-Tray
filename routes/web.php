<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

  return view('welcome');
});

Auth::routes();



Route::get('/home', 'HomeController@index')->name('home.index');

Route::get('/Vender', 'VendaController@Vender')->name('home.Vender');
Route::get('/relVenda', 'VendaController@relVenda')->name('home.relVenda');

Route::get('/VendedorUpdate/{id}', 'VendedorController@VendedorUpdate');
Route::get('/updateVendedor', 'VendedorController@updateVendedor');

Route::resource('/vendedor', 'VendedorController');

Route::get('/ProdutoUpdate/{id}', 'ProdutoController@ProdutoUpdate');
Route::get('/updateProduto', 'ProdutoController@updateProduto');

Route::resource('/produto', 'ProdutoController');

Route::get('send-mail', function () {
   
  $details = [
      'title' => 'Mail from ItSolutionStuff.com',
      'body' => 'This is for testing email using smtp'
  ];
  
  Mail::to('pauloavital@gmail.com')->send(new \App\Mail\TraySendMail($details));
 
  dd("Email is Sent.");
});


