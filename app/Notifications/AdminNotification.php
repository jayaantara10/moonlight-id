<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Transaction;
use App\ProductReview;
class AdminNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($statusFoto, Transaction $transaction, ProductReview $review, $type)
    {
        $this->transaction=$transaction;
        $this->review=$review;
        $this->type=$type;
        $this->statusFoto = $statusFoto;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function via($notifiable)
    // {
    //     return ['mail'];
    // }
    public function via($notifiable)
    {
        return [CustomDbChannelAdmin::class]; //<-- important custom Channel defined here
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
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        if ($this->type == "review") {
            $message = $this->review->content;
            $status = null;
            $review_id = $this->review->id;
            $transaction_id = null;
        } else {
            if ($this->statusFoto == 1) {
                $message = "Pembeli mengunggah bukti pembayaran";
            } else if ($this->statusFoto == 0) {
                $message = "Cek transaksi baru!";
            } else {
                if ($this->transaction->status == "canceled") {
                    $message = "Transaksi telah dibatalkan oleh pembeli !";
                } 
            }
            $transaction_id = $this->transaction->id;
            $status = $this->transaction->status;
            $review_id = null;
        }
        $arr=[
            'transaction_id' => $transaction_id,
            'review_id' => $review_id,
            'type' => $this->type,
            'status' => $status,
            'foto' => $this->statusFoto,
            'message' => $message,
        ];
        return json_encode($arr);
    }
}
