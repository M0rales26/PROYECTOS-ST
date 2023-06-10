<?php

namespace App\Listeners;

use App\Models\User;
use App\Events\FacturasCompletadas;
use App\Notifications\TodasFacturasCompletadasNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\DB;

class EnviarNotificacionFacturasCompletadas{
    /**
     * Maneja el evento FacturasCompletadas.
     *
     * @param  FacturasCompletadas  $event
     * @return void
     */
    public function handle(FacturasCompletadas $event){
        $facturaId = $event->facturaId;
        // Verificar si todos los registros de la factura están completados
        $facturaCompletada = DB::table('tbl_factura_producto')
            ->where('factura_id', $facturaId)
            ->where('estado', '!=', 'COMPLETADO')
            ->doesntExist();
        //      //
        if ($facturaCompletada) {
            // Todos los registros de la factura están completados
            // Obtener el cliente que generó la factura
            $clienteId = DB::table('tbl_factura')
            ->where('id_factura', $facturaId)
                ->value('cliente_id');
            if ($clienteId) {
                $user = User::find($clienteId);
                $user->notify(new TodasFacturasCompletadasNotification($facturaId));
            }
        }
    }
}

