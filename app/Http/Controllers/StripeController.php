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
        $err  = $body['error'];

        print('Status is:' . $e->getHttpStatus() . "\n");
        print('Type is:' . $err['type'] . "\n");
        print('Code is:' . $err['code'] . "\n");
        // param is '' in this case
        print('Param is:' . $err['param'] . "\n");
        print('Message is:' . $err['message'] . "\n");
      } catch (\Stripe\Error\RateLimit $e) {
        // Too many requests made to the API too quickly
      } catch (\Stripe\Error\InvalidRequest $e) {
        // Invalid parameters were supplied to Stripe's API
      } catch (\Stripe\Error\Authentication $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
      } catch (\Stripe\Error\ApiConnection $e) {
        // Network communication with Stripe failed
      } catch (\Stripe\Error\Base $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email
      } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
      }
    }

    public function charge(Request $request){
      try {
        // Use Stripe's library to make requests...
      } catch(\Stripe\Error\Card $e) {
        // Since it's a decline, \Stripe\Error\Card will be caught
        $body = $e->getJsonBody();
        $err  = $body['error'];

        print('Status is:' . $e->getHttpStatus() . "\n");
        print('Type is:' . $err['type'] . "\n");
        print('Code is:' . $err['code'] . "\n");
        // param is '' in this case
        print('Param is:' . $err['param'] . "\n");
        print('Message is:' . $err['message'] . "\n");
      } catch (\Stripe\Error\RateLimit $e) {
        // Too many requests made to the API too quickly
      } catch (\Stripe\Error\InvalidRequest $e) {
        // Invalid parameters were supplied to Stripe's API
      } catch (\Stripe\Error\Authentication $e) {
        // Authentication with Stripe's API failed
        // (maybe you changed API keys recently)
      } catch (\Stripe\Error\ApiConnection $e) {
        // Network communication with Stripe failed
      } catch (\Stripe\Error\Base $e) {
        // Display a very generic error to the user, and maybe send
        // yourself an email
      } catch (Exception $e) {
        // Something else happened, completely unrelated to Stripe
      }
    }
}
