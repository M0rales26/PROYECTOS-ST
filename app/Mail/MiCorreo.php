<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class MiCorreo extends Mailable{
    use Queueable, SerializesModels;
    public $texto;
    public function __construct($texto){
        $this->texto = $texto;
    }
    //      //
    public function build(){
    $html = '
            <h1>¡Hola!</h1>
            <p>Este es el contenido de mi correo:</p>
            <p>' . $this->texto . '</p>
        ';

        return $this
            ->from('laravelproyectoadsi@gmail.com', 'SolTiend')
            ->subject('Asunto del Correo')
            ->html($html);
    }
}
