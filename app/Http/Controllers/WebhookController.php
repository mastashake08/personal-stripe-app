<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\StripeNotification;
class WebhookController extends Controller
{
    //
    public function handle(Request $request){
      event(new StripeNotification($request->type, $request->data['object']))
    }
}
