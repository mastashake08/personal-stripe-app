<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StripeController extends Controller
{
    public function __construct(){
      \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
    }
    //
    public function getBalance(){
      $balance = \Stripe\Balance::retrieve();
      $available = money_format(" $%i", $balance['available'][0]->amount/100);
      $pending = money_format(" $%i", $balance['pending'][0]->amount/100);

      $json = [
        'available' => $available,
        'pending' => $pending
      ];

      return response()->json($json);
    }
}
