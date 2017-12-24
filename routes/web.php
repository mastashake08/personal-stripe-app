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

Route::get('/', function () {
    return view('welcome');
});
Route::get('/invoice',function(){
  return view('invoice');
});
Route::get('/subscriptions',function(){
  return view('customers');
});
Route::post('/invoice','StripeController@sendInvoice');
Auth::routes();
Route::get('/pay-invoice/{id}','StripeController@getInvoice');
Route::get('/home', 'HomeController@index');
Route::get('/view-details','StripeController@getEvent');
Route::get('/complete-registration','CustomerController@completeRegistrationView');
Route::post('/complete-registration','CustomerController@completeRegistration');
Route::get('/how-to-check',function(){
  return view('/registration-success');
});
