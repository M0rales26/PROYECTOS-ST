<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TodasFacturasCompletadasNotification extends Notification
{
    use Queueable;

    /**
    * El número de la factura completada.
    *
    * @var int
    */
    protected $facturaNumero;

    /**
    * Crea una nueva instancia de la notificación.
    *
    * @param int $facturaNumero
    * @return void
    */
    public function __construct($facturaNumero)
    {
    $this->facturaNumero = $facturaNumero;
    }

    /**
    * Obtiene los canales de entrega de la notificación.
    *
    * @param mixed $notifiable
    * @return array|string
    */
    public function via($notifiable)
    {
    return ['mail'];
    }

    /**
    * Obtiene la representación del mensaje de correo electrónico de la notificación.
    *
    * @param mixed $notifiable
    * @return \Illuminate\Notifications\Messages\MailMessage
    */
    public function toMail($notifiable)
    {
        return (new MailMessage)
        ->from('laravelproyectoadsi@gmail.com', 'SolTiend')
        ->subject('Factura Completada')
		->greeting('Hola')
        ->line('La factura número ' . $this->facturaNumero . ' ha sido completada.')
        ->salutation('¡Gracias por usar nuestra aplicación!');
    }
}