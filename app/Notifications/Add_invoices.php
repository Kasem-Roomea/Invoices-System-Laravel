<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use App\Models\invoice;

class Add_invoices extends Notification
{
    use Queueable;
    private $invoice;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(invoice $invoice)
    {
        $this-> invoice = $invoice;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['database'];
    }



    public function toDatabase($notifiable)
    {
        return[

                'id' => $this->invoice->id,
                'title' => 'تم أضافة فاتورة بواسطة',
                'user' => Auth::user()->name
        ];
    }



}
