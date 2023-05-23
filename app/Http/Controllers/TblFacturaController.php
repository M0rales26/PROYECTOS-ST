<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Tbl_Factura;
use App\Models\Tbl_Factura_Producto;
use App\Models\Tbl_Producto;
use Barryvdh\DomPDF\Facade\PDF;

class TblFacturaController extends Controller{
    public function historial(){
        $usuario = Auth::user()->id_usuario;
        //      //
        $facturas = DB::table('tbl_factura')
            ->select('id_factura','cliente_id','total', DB::raw('(SELECT MAX(estado) FROM tbl_factura_producto WHERE tbl_factura_producto.factura_id = tbl_factura.id_factura) as estado'))
            ->where('cliente_id',$usuario)
            ->orderBy('id_factura','ASC')
            ->paginate(16);
        //      //
        if ($facturas->isEmpty()) {
            $error = 'Aún no se han realizado compras';
            return view('templates.historial', compact('facturas','usuario','error'));
        }else{
            return view('templates.historial', compact('facturas','usuario'));
        }
    }
    //      //
    public function pdfhistorial($id){
        $factura = DB::table('tbl_factura')
            ->select('id_factura','total','tbl_factura.created_at')
            ->where('id_factura','=',$id)
            ->get();
        //     //
        $factura_producto = DB::table('tbl_factura_producto')
            ->select('id_factura_producto','total_producto','cantidad','tendero_id','producto_id','factura_id','tbl_producto.nombrep','tbl_producto.peso_neto','tbl_producto.precio','tbl_usuario.name','tbl_usuario.rol_id')
            ->join('tbl_factura','tbl_factura_producto.factura_id','=','tbl_factura.id_factura')
            ->join('tbl_producto','tbl_factura_producto.producto_id','=','tbl_producto.id_producto')
            ->join('tbl_usuario','tbl_factura_producto.tendero_id','=','tbl_usuario.id_usuario')
            ->where('factura_id','=',$id)
            ->get();
        //      //
        $pdf = PDF::loadview('templates.pdf.facturac',['factura'=>$factura,'factura_producto'=>$factura_producto]);
        return $pdf->stream();
    }
    //      //
    public function store(Request $request){
        $facturaCreada = false;
        $id_producto = $request->id;
        $total_prod  = $request->total_prod;
        $cantidad    = $request->cantidad;
        $id_tendero  = $request->id_tendero;
        //      //
        for ($i = 0; $i < count($id_producto); $i++) {
            $producto = tbl_producto::findOrFail($id_producto[$i]);
            $cantidad_vendida = $cantidad[$i];
            // Verificar si hay suficiente stock disponible
            if ($producto->stock >= $cantidad_vendida) {
                // Restar la cantidad vendida del stock del producto
                $producto->update(['stock' => $producto->stock - $cantidad_vendida]);
                // Crear la factura solo una vez
                if (!$facturaCreada) {
                    $factura = request()->except('id', 'total_prod', 'cantidad', 'id_tendero', '_token');
                    Tbl_Factura::create($factura);
                    $facturaCreada = true;
                    // Guardar los detalles de la factura
                }
                $id_factura = tbl_Factura::max('id_factura');
                $datasave = [
                    'producto_id' => $id_producto[$i],
                    'total_producto' => $total_prod[$i],
                    'cantidad' => $cantidad_vendida,
                    'factura_id' => $id_factura,
                    'tendero_id' => $id_tendero[$i],
                    'estado' => 'PENDIENTE',
                ];
                DB::table('tbl_factura_producto')->insert($datasave);
                return redirect()->back()->with('success', 'La compra se registró con exito!');
            } else {
                return redirect()->back()->with('error', 'No hay suficiente cantidad de producto disponible.');
            }
            if($producto->stock == '0'){
                $producto->update(['estado' => 'DESHABILITADO']);
            }
        }
        return redirect()->back();
    }
    //      //
    public function pdf(){
        $usuario_id = Auth::user()->id_usuario;
        $factura_id = tbl_factura::where('cliente_id', $usuario_id)
            ->latest('created_at')
            ->value('id_factura');
        //      //
        if(!$factura_id) {
            return redirect()->back()->with('error', 'No hay facturas para este cliente.');
        }
        //      //
        $id_factura = tbl_factura::max('id_factura');
        $factura = DB::table('tbl_factura')
            ->select('id_factura','total','tbl_factura.created_at')
            ->where('id_factura','=',$id_factura)
            ->get();
        //     //
        $factura_producto = DB::table('tbl_factura_producto')
            ->select('id_factura_producto','total_producto','cantidad','tendero_id','producto_id','factura_id','tbl_producto.nombrep','tbl_producto.peso_neto','tbl_producto.precio','tbl_usuario.name','tbl_usuario.rol_id')
            ->join('tbl_factura','tbl_factura_producto.factura_id','=','tbl_factura.id_factura')
            ->join('tbl_producto','tbl_factura_producto.producto_id','=','tbl_producto.id_producto')
            ->join('tbl_usuario','tbl_factura_producto.tendero_id','=','tbl_usuario.id_usuario')
            ->where('factura_id','=',$id_factura)
            ->get();
        //      //
        $pdf = PDF::loadview('templates.pdf.facturac',['factura'=>$factura,'factura_producto'=>$factura_producto]);
        return $pdf->stream();
    }
    public function pdf2($id){
        $usuario = Auth::user()->id_usuario;
        //      //
        $factura = DB::table('tbl_factura')
            ->select('id_factura','total','cliente_id','tbl_usuario.name','tbl_factura.created_at')
            ->join('tbl_usuario','tbl_factura.cliente_id','=','tbl_usuario.id_usuario')
            ->where('id_factura','=',$id)
            ->get();
        //     //
        $factura_producto = DB::table('tbl_factura_producto')
            ->select('id_factura_producto','total_producto','cantidad','tendero_id','producto_id','factura_id','tbl_producto.nombrep','tbl_producto.peso_neto','tbl_producto.precio','tbl_usuario.name','tbl_usuario.rol_id')
            ->join('tbl_factura','tbl_factura_producto.factura_id','=','tbl_factura.id_factura')
            ->join('tbl_producto','tbl_factura_producto.producto_id','=','tbl_producto.id_producto')
            ->join('tbl_usuario','tbl_factura_producto.tendero_id','=','tbl_usuario.id_usuario')
            ->where('factura_id','=',$id)
            ->where('tendero_id','=',$usuario)
            ->get();
        //      //
        $sum = tbl_factura_producto::where('factura_id', $id)
            ->where('tendero_id',$usuario)
            ->sum('total_producto');
        //     //
        $pdf = PDF::loadview('templates.pdf.facturat',['factura'=>$factura,'factura_producto'=>$factura_producto,'sum'=>$sum]);
        return $pdf->stream();
    }
    public function cambiarestado($id){
        $usuario = Auth::user()->id_usuario;
        //      //
        $factura = DB::table('tbl_factura_producto')
            ->select('estado','factura_id')
            ->where('factura_id','=',$id)
            ->where('tendero_id','=',$usuario)
            ->first();
        //      //
        if ($factura->estado == 'PENDIENTE'){
            DB::table('tbl_factura_producto')
                ->select('estado')
                ->where('factura_id','=',$id)
                ->where('tendero_id','=',$usuario)
                ->update(['estado'=>'COMPLETADO']);
            return redirect()->back();
        } else {
            DB::table('tbl_factura_producto')
                ->select('estado')
                ->where('factura_id','=',$id)
                ->where('tendero_id','=',$usuario)
                ->update(['estado'=>'PENDIENTE']);
            return redirect()->back();
        }
    }
    //      //
    public function pendiente(){
        $rol = Auth::user()->rol_id;
        $usuario = Auth::user()->id_usuario;
        //      //
        $facturas = DB::table('tbl_factura_producto')
            ->select('factura_id', 'estado', DB::raw('(SELECT name FROM tbl_usuario WHERE tbl_factura.cliente_id = tbl_usuario.id_usuario AND rol_id = 1) as name'))
            ->join('tbl_usuario', 'tbl_factura_producto.tendero_id','=','tbl_usuario.id_usuario')
            ->join('tbl_factura', 'tbl_factura_producto.factura_id','=','tbl_factura.id_factura')
            ->where('rol_id','=',$rol)
            ->where('tendero_id','=',$usuario)
            ->where('estado','=','PENDIENTE')
            ->distinct('tendero_id')
            ->orderBy('factura_id','ASC')
            ->paginate(16);
        //      //
        if ($facturas->isEmpty()) {
            $error = 'No hay facturas pendientes';
            return view('templates.estadof.pendientes', compact('facturas','usuario','rol','error'));
        }else{
            return view('templates.estadof.pendientes', compact('facturas','usuario','rol',));
        }
    }
    //      //
    public function completado(){
        $rol = Auth::user()->rol_id;
        $usuario = Auth::user()->id_usuario;
        //      //
        $facturas = DB::table('tbl_factura_producto')
            ->select('factura_id', 'estado', DB::raw('(SELECT name FROM tbl_usuario WHERE tbl_factura.cliente_id = tbl_usuario.id_usuario AND rol_id = 1) as name'))
            ->join('tbl_usuario', 'tbl_factura_producto.tendero_id','=','tbl_usuario.id_usuario')
            ->join('tbl_factura', 'tbl_factura_producto.factura_id','=','tbl_factura.id_factura')
            ->where('rol_id','=',$rol)
            ->where('tendero_id','=',$usuario)
            ->where('estado','=','COMPLETADO')
            ->distinct('tendero_id')
            ->orderBy('factura_id','ASC')
            ->paginate(16);
        //      //
        if ($facturas->isEmpty()) {
            $error = 'No hay facturas completadas';
            return view('templates.estadof.completado', compact('facturas','usuario','rol','error'));
        }else{
            return view('templates.estadof.completado', compact('facturas','usuario','rol',));
        }
    }
}