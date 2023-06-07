<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ComparacionController extends Controller{
    public function comparar(Request $request){
        $boton = trim($request->get('boton'));
        $producto = DB::table('tbl_producto')
                    ->select('id_producto','nombrep','precio','peso_neto','foto','estado','stock','tbl_usuario.name')
                    ->join('tbl_usuario','tbl_producto.usuario_id','=','tbl_usuario.id_usuario')
                    ->where('nombrep','LIKE','%'.$boton.'%')
                    ->where('estado','HABILITADO')
                    ->orderBy('precio','asc')
                    ->paginate(12);
        return view('templates.comparacion', compact('producto','boton'));
    }
    //      //
    // public function grafica(Request $request, $id){
    //     $productos = DB::table('tbl_producto_auditoria')
    //         ->select('updated_at', 'precio')
    //         ->where('producto_id', $id)
    //         ->orderBy('updated_at')
    //         ->get();
    //     // Preparar los datos para la gráfica
    //     $fechas = [];
    //     $precios = [];
    //     foreach ($productos as $producto) {
    //         $fecha = Carbon::parse($producto->updated_at);
    //         $fechas[] = $fecha->format('Y-m-d');
    //         $precios[] = $producto->precio;
    //     }
    //     //      //
    //     $uno = DB::table('tbl_producto')
    //                 ->select('id_producto','nombrep','precio','peso_neto','foto','estado')
    //                 ->where('id_producto',$id)
    //                 ->where('estado','HABILITADO')
    //                 ->get();
    //     //      //
    //     // Devolver la vista con los datos para la gráfica
    //     return view('templates.grafica', [
    //         'fechas' => $fechas,
    //         'precios' => $precios,
    //         'producto' => $uno
    //     ]);
    // }
    //      //
    public function grafica(Request $request, $id){
        // Obtener la fecha actual
        $fechaActual = Carbon::now();
        // Obtener el mes de la solicitud o el mes actual si no se proporciona
        $mes = $request->input('mes', $fechaActual->month);
        $anio = $request->input('anio', $fechaActual->year);
        // Verificar si el mes seleccionado es menor o igual al mes actual
        $esMesActual = ($anio == $fechaActual->year && $mes == $fechaActual->month);
        $esMesSiguiente = ($anio == $fechaActual->year && $mes == $fechaActual->month + 1);
        // Obtener el último precio del mes anterior
        $ultimoPrecioMesAnterior = DB::table('tbl_producto_auditoria')
            ->select('precio')
            ->where('producto_id', $id)
            ->whereMonth('updated_at', $mes - 1)
            ->whereYear('updated_at', $anio)
            ->orderByDesc('updated_at')
            ->value('precio');
        // Obtener los productos filtrados por mes y año hasta la fecha actual o el último día del mes
        $productos = DB::table('tbl_producto_auditoria')
            ->select('updated_at', 'precio')
            ->where('producto_id', $id)
            ->whereYear('updated_at', $anio)
            ->whereMonth('updated_at', $mes)
            ->whereDate('updated_at', '<=', $esMesActual ? $fechaActual : Carbon::create($anio, $mes)->endOfMonth())
            ->orderBy('updated_at')
            ->get();
        // Crear un rango de fechas hasta la fecha actual o el último día del mes
        $fechaInicio = Carbon::create($anio, $mes, 1)->startOfMonth();
        $ultimoDiaMes = $esMesActual ? $fechaActual : Carbon::create($anio, $mes)->endOfMonth();
        $fechasMes = [];
        while ($fechaInicio <= $ultimoDiaMes) {
            $fechasMes[] = $fechaInicio->format('Y-m-d');
            $fechaInicio->addDay();
        }
        // Iterar sobre el rango de fechas y obtener los precios correspondientes
        $fechas = [];
        $precios = [];
        $ultimoPrecio = $ultimoPrecioMesAnterior; // Utilizar el último precio del mes anterior inicialmente
        foreach ($fechasMes as $fecha) {
            $producto = $productos->first(function ($producto) use ($fecha) {
                return Carbon::parse($producto->updated_at)->toDateString() === $fecha;
            });
            if ($producto) {
                $ultimoPrecio = $producto->precio; // Actualizar el último precio disponible
            }
            $fechas[] = $fecha;
            $precios[] = $ultimoPrecio;
        }
        // Si es el mes siguiente al actual, vaciar los datos de la gráfica
        if ($esMesSiguiente) {
            $fechas = [];
            $precios = [];
        }
        // Obtener la información adicional del producto
        $uno = DB::table('tbl_producto')
            ->select('id_producto', 'nombrep', 'precio', 'peso_neto', 'foto', 'estado')
            ->where('id_producto', $id)
            ->where('estado', 'HABILITADO')
            ->get();
        // Devolver la vista con los datos para la gráfica
        // if($fechas->isEmpty() && $precios->isEmpty() && $uno->isEmpty()){
        //     $error = 'No se encontraron datos';
        //     return view('templates.grafica', compact('error'));
        // }else{
            return view('templates.grafica', [
                'fechas' => $fechas,
                'precios' => $precios,
                'producto' => $uno,
            ]);
        // }
    }
}