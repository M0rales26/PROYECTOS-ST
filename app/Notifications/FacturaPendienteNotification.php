<?php
namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FacturaPendienteNotification extends Notification
{
    use Queueable;

    protected $numeroFactura;

    /**
     * Create a new notification instance.
     *
     * @param  string  $numeroFactura
     * @return void
     */
    public function __construct($numeroFactura)
    {
        $this->numeroFactura = $numeroFactura;
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
        $numeroFactura = $this->numeroFactura; // Obtener el número de factura

        return (new MailMessage)
            ->from('laravelproyectoadsi@gmail.com', 'SolTiend')
            ->subject('Factura Pendiente')
            ->greeting('Hola')
            ->line('Estimado ' . $notifiable->name)
            ->line('tienes una factura pendiente.')
            ->line('Número de factura: ' . $numeroFactura)
            ->salutation('Saludos');
            // Resto del contenido del correo
            // ...
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
