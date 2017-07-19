<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class StripeNotification extends Notification
{
    use Queueable;
    public $type,$data,$message, $event_id,$test;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type,$data=null,$message=null,$id=null,$test=false)
    {
        //
        $this->type = $type;
        $this->data = $data;
        $this->message = $message;
        $this->event_id = $id;
        $this->test = $test;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [WebPushChannel::class];

    }

    public function toWebPush($notifiable, $notification)
    {
        if($this->test){

          if($this->message !== null){
            return WebPushMessage::create()

                ->title('New Stripe Notification - '. $this->type)
                ->icon(url('/push.png'))
                ->body($this->message);

          }
          return WebPushMessage::create()
              ->id($this->event_id)
              ->title('New Stripe Notification - '. $this->type)
              ->icon(url('/push.png'))
              ->body("$".money_format('%.2n', $this->data["amount"]/100))
              ->action('View Details','view_details_test');
        }
        else{
        if($this->message !== null){
          return WebPushMessage::create()

              ->title('New Stripe Notification - '. $this->type)
              ->icon(url('/push.png'))
              ->body($this->message);

        }
        return WebPushMessage::create()
            ->id($this->event_id)
            ->title('New Stripe Notification - '. $this->type)
            ->icon(url('/push.png'))
            ->body("$".money_format('%.2n', $this->data["amount"]/100))
            ->action('View Details','view_details');
          }
    }


}
