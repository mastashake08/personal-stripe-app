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
    public $type,$data,$message $event_id,;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type,$data=null,$message=null,$id=null)
    {
        //
        $this->type = $type;
        $this->data = $data;
        $this->message = $message;
        $this->event_id = $id;
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
        if($this->message !== null){
          return WebPushMessage::create()
              // ->id($notification->id)
              ->title('New Stripe Notification - '. $this->type)
              ->icon(url('/push.png'))
              ->body($this->message)
              ->action('View Details','view_details');

        }
        return WebPushMessage::create()
            // ->id($notification->id)
            ->title('New Stripe Notification - '. $this->type)
            ->icon(url('/push.png'))
            ->body("$".money_format('%.2n', $this->data["amount"]/100));
    }


}
