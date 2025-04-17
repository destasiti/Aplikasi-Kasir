<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewCashierAccountNotification extends Notification
{
    use Queueable;

    protected $password;
    protected $name;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $password)
    {
        $this->name = $name;
        $this->password = $password;
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
                    ->subject('Akun Kasir Anda Telah Dibuat')
                    ->greeting('Halo ' . $this->name . '!')
                    ->line('Akun kasir untuk Anda telah dibuat oleh admin.')
                    ->line('Berikut detail akun Anda:')
                    ->line('Email: ' . $notifiable->email)
                    ->line('Password: ' . $this->password)
                    ->line('Silakan login menggunakan kredensial di atas.')
                    ->action('Login Sekarang', url('/login'))
                    ->line('Harap segera mengganti password Anda setelah login untuk keamanan akun Anda.')
                    ->line('Terima kasih telah menggunakan aplikasi kami!');
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