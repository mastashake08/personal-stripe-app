<?php

use Illuminate\Http\Request;

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

Route::get('/balance','StripeController@getBalance');
Route::post('/charge','StripeController@charge');
Route::post('/quick-charge','StripeController@quickCharge');;
Route::post('/webhook','WebhookController@handle');
Route::group(['prefix' => 'test'],function(){
  Route::post('/webhook','WebhookController@handleTest');
});
Route::post('/save-subscription',function(Request $request){
  $user = $request->user();

  $user->updatePushSubscription($request->input('endpoint'), $request->input('keys.p256dh'), $request->input('keys.auth'));
  $user->notify(new \App\Notifications\StripeNotification("Welcome To WebPush", "You will now get all of our push notifications"));
  return response()->json([
    'success' => true
  ]);
})->middleware('auth:api');

Route::post('/send-notification/{id}', function($id, Request $request){
  $user = \App\User::findOrFail($id);
  $user->notify(new \App\Notifications\StripeNotification($request->title, $request->body));
  return response()->json([
    'success' => true
  ]);
});
