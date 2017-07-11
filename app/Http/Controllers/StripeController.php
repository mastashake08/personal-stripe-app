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
      try {
        // Use Stripe's library to make requests...
        $balance = \Stripe\Balance::retrieve();
        $available = money_format(" $%i", $balance['available'][0]->amount/100);
        $pending = money_format(" $%i", $balance['pending'][0]->amount/100);

        $json = [
          'available' => $available,
          'pending' => $pending
        ];

        return response()->json($json);
      } catch(\Stripe\Error\Card $e) {
        // Since it's a decline, \Stripe\Error\Card will be caught
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (\Stripe\Error\RateLimit $e) {
        // Too many requests made to the API too quickly
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (\Stripe\Error\InvalidRequest $e) {
        // Invalid parameters were supplied to Stripe's API
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (\Stripe\Error\Authentication $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (\Stripe\Error\ApiConnection $e) {
        // Network communication with Stripe failed
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (\Stripe\Error\Base $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
        $body = $e->getJsonBody();
        return response()->json($body);
      }
    }

    public function charge(Request $request){
      try {
        $invoice = \App\Invoice::findOrFail($request->id);
        // Use Stripe's library to make requests...
        \Stripe\Charge::create([
          "amount" => $invoice->amount * 100,
          "currency" => "usd",
          "source" => $stripeToken, // obtained with Stripe.js

        ]);
        $json = [
          'success' => true
        ];
        return response()->json($json);
      } catch(\Stripe\Error\Card $e) {
        // Since it's a decline, \Stripe\Error\Card will be caught
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (\Stripe\Error\RateLimit $e) {
        // Too many requests made to the API too quickly
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (\Stripe\Error\InvalidRequest $e) {
        // Invalid parameters were supplied to Stripe's API
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (\Stripe\Error\Authentication $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (\Stripe\Error\ApiConnection $e) {
        // Network communication with Stripe failed
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (\Stripe\Error\Base $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email
        $body = $e->getJsonBody();
        return response()->json($body);
      } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
        $body = $e->getJsonBody();
        return response()->json($body);
      }
    }

    public function sendInvoice(Request $request){
      $invoice = \App\Invoice::create($request->all());
      $invoice->notify(new \App\Notifications\SendInvoice());
      return redirect('/');
    }
    public function getInvoice($id){
      $with = [
        'invoice' => \App\Invoice::findOrFail($id)
      ];
      return view('pay-invoice')->with($with);
    }
}
