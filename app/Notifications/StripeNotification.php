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
    public $type,$data;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($type,$data)
    {
        //
        $this->type = $type;
        $this->data = $data;
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
        return WebPushMessage::create()
            // ->id($notification->id)
            ->title('New Stripe Notification - '. $this->type)
            ->icon('/approved-icon.png')
            ->body($this->data)
            ->action('View account', 'view_account');
    }


}