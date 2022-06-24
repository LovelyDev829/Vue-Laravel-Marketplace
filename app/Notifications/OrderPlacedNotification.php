<?php

namespace App\Notifications;

use App\Models\CombinedOrder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class OrderPlacedNotification extends Notification implements ShouldQueue
{
    use Queueable;
    
    protected $combined_order;

    public function __construct(CombinedOrder $combined_order)
    {
        $this->combined_order = $combined_order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $array['subject'] = translate('Your order has been placed') . ' - ' . $this->combined_order->code;
        $array['order'] = $this->combined_order;

        return (new MailMessage)
            ->view('emails.invoice', ['array' => $array, 'combined_order' => $this->combined_order])
            ->from(env('MAIL_FROM_ADDRESS'))
            ->subject(translate('Order Placed').' - '.env('APP_NAME'));
    }

    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
