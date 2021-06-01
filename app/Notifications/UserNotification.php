<?php

namespace App\Notifications;
use App\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Transaction;
use App\Response;
class UserNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Transaction $transaction, Response $response, $type)
    {
        $this->transaction=$transaction;
        $this->response=$response;
        $this->type=$type;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    // public function via($notifiable)
    // {
    //     return ['database','mail'];
    // }
    public function via($notifiable)
    {
        return [CustomDbChannel::class];
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
        if ($this->type == "response") {
            $message = $this->response->content;
            $status = null;
            $response_id = $this->response->id;
            $transaction_id = null;
        } else {
            if ($this->transaction->status == "verified") {
                $message = "Transaksi anda telah diverifikasi!";
            } else if ($this->transaction->status == "canceled") {
                $message = "Transaksi anda telah dibatalkan oleh admin !";
            } else if ($this->transaction->status == "expired") {
                $message = "Mohon maaf, transaksi anda sudah melewati batas waktu !";
            } else if ($this->transaction->status == "delivered") {
                $message = "Pesananmu sudah dikirim, tunggu ya !";
            } else if ($this->transaction->status == "success") {
                $message = "Transaksi anda telah berhasil, Terima Kasih!";
            } else {
                $message = "Menunggu verifikasi";
            }
            $status = $this->transaction->status;
            $response_id = null;
            $transaction_id = $this->transaction->id;
        }
        $arr=[
            'transaction_id' => $transaction_id,
            'response_id' => $response_id,
            'type' => $this->type,
            'status' => $status,
            'message' => $message,
            'admin_id' => 2,
        ];
        return json_encode($arr);
    }
}
