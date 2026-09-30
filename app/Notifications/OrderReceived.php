<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderReceived extends Notification
{
    public function __construct(public Order $order) {}

    /** @return list<string> */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)->subject('ORIGINA order #'.$this->order->id.' received')->greeting('Thank you for your order.')->line('We received your order for TZS '.number_format($this->order->total).'. Payment is pending.')->line((string) config('commerce.payment_instructions'))->action('View your order', route('account.orders.show', $this->order))->line('Do not send payment without confirmed instructions.');
    }
}
