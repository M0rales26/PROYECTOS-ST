<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;


class ProductosSinStockNotification extends Notification
{
	use Queueable;

	protected $productos;

	/**
		* Create a new notification instance.
		*
		* @param array $productos
		* @return void
		*/
	public function __construct(array $productos)
	{
		$this->productos = $productos;
	}

	/**
		* Get the notification's delivery channels.
		*
		* @param mixed $notifiable
		* @return array
		*/
	public function via($notifiable)
	{
		return ['mail']; // Aquí puedes especificar los canales de entrega de la notificación, como 'mail', 'database', etc.
	}

	/**
		* Get the mail representation of the notification.
		*
		* @param mixed $notifiable
		* @return \Illuminate\Notifications\Messages\MailMessage
		*/
	public function toMail($notifiable)
	{
		// Construye el mensaje de correo electrónico con los productos sin stock
		$message = "Los siguientes productos se han quedado sin stock:\n\n";
		foreach ($this->productos as $producto) {
			$message .= "- " . $producto . "\n";
		}
		return (new MailMessage)
			->from('laravelproyectoadsi@gmail.com', 'SolTiend')
			->subject('Productos sin stock')
			->greeting('Hola')
			->line('Estimado vendedor,')
			->line($message)
			->line('Por favor, actualiza el stock de tus productos lo antes posible.')
			->salutation('Gracias por tu atención.');
	}
}
