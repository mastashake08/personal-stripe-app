<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class NewSubscription extends Notification
{
    use Queueable;
    public $plan_id;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($plan_id)
    {
        //
        $this->plan_id = $plan_id;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Please Finish Your Web Hosting Registration')
                    ->line('You are almost ready to start your new web business!')
                    ->line('Please enter your payment details and create your first email account!')
                    ->action('Complete Now!', url('/complete-registration?customer_id='.$notifiable->customer_id.'&plan_id='.$this->plan_id))
                    ->line('Thank you for choosing me to host your web site!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
