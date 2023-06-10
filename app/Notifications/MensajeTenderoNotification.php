<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class MensajeTenderoNotification extends Notification
{
    use Queueable;
    protected $texto;
    protected $senderName;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($texto,$senderName)
    {
        $this->texto = $texto;
        $this->senderName = $senderName;
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
        $texto = $this->texto; // Obtener el mensaje
        $senderName = $this->senderName; // Obtener el nombre del tendero
        //      //
        return (new MailMessage)
            ->from('soltiendmedellin@gmail.com', 'SolTiend')
            ->subject('Mensaje de Vendedor')
            ->greeting('Hola')
            ->line('Estimado administrador.')
            ->line('El vendedor '.$senderName.' envió un mensaje.')
            ->line('"'.$texto.'"')
            ->salutation('Saludos.');
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
