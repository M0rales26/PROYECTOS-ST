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
    public function grafica(Request $request, $id){
        $productos = DB::table('tbl_producto_auditoria')
            ->select('updated_at', 'precio')
            ->where('producto_id', $id)
            ->orderBy('updated_at')
            ->get();
        // Preparar los datos para la gráfica
        $fechas = [];
        $precios = [];
        foreach ($productos as $producto) {
            $fecha = Carbon::parse($producto->updated_at);
            $fechas[] = $fecha->format('Y-m-d');
            $precios[] = $producto->precio;
        }
        //      //
        $uno = DB::table('tbl_producto')
                    ->select('id_producto','nombrep','precio','peso_neto','foto','estado')
                    ->where('id_producto',$id)
                    ->where('estado','HABILITADO')
                    ->get();
        //      //
        // Devolver la vista con los datos para la gráfica
        return view('templates.grafica', [
            'fechas' => $fechas,
            'precios' => $precios,
            'producto' => $uno
        ]);
    }
}
