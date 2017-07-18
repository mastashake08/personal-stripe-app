<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Notifications\StripeNotification;
class WebhookController extends Controller
{
    //
    public function handle(Request $request){
      $user = \App\User::findOrFail(1);
      $user->notify(new StripeNotification($request->type, $request->data['object'],null,$request->id));
    }
}
