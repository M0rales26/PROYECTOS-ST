<?php

namespace App\Events;

class FacturasCompletadas
{
    public $facturaId;

    /**
     * Crea una nueva instancia del evento.
     *
     * @param  int  $facturaId
     * @return void
     */
    public function __construct($facturaId)
    {
        $this->facturaId = $facturaId;
    }
}
