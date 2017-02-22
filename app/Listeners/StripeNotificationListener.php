<?php

namespace App\Listeners;

use App\Events\StripeNotification;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class StripeNotificationListener implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  StripeNotification  $event
     * @return void
     */
    public function handle(StripeNotification $event)
    {
        //
      
    }
}
