<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class GetStripeBalance extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'balance:get';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get Stripe Balance';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
      \Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
        try {
          // Use Stripe's library to make requests...
          $balance = \Stripe\Balance::retrieve();
          $available = money_format(" $%i", $balance['available'][0]->amount/100);
          $pending = money_format(" $%i", $balance['pending'][0]->amount/100);

          $message = "Available: {$available}. Pending {$pending}";
          $title = "Your Daily Stripe Balance";
          $user = \App\User::findOrFail(1);
          $user->notify(new \App\Notifications\StripeNotification($title,null,$message));
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
}
