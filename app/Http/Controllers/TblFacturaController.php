<?php

namespace App\Http\Controllers;

use \App\Events\FacturasCompletadas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Tbl_Factura;
use App\Models\Tbl_Factura_Producto;
use App\Models\Tbl_Producto;
use Barryvdh\DomPDF\Facade\PDF;
use App\Notifications\ProductosSinStockNotification;
use App\Models\User;
use App\Notifications\FacturaPendienteNotification;
use Carbon\Carbon;

class TblFacturaController extends Controller{
#region historial
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
#endregion
#region pdf´s
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
#endregion
#region pdfhistorial
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
#endregion
#region store
    public function store(Request $request){
        $id_producto = $request->id;
        $total_prod  = $request->total_prod;
        $cantidad    = $request->cantidad;
        $id_tendero  = $request->id_tendero;
        $excedeStock = false;
        $productosSinStockPorVendedor = [];
        $vendedoresFacturaPendiente=[];
        // Verificar si se excede el stock
        for ($i = 0; $i < count($id_producto); $i++) {
            $producto = tbl_producto::findOrFail($id_producto[$i]);
            $cantidad_vendida = $cantidad[$i];
            if ($cantidad_vendida > $producto->stock) {
                $excedeStock = true;
                break;
            }
        }
        if ($excedeStock) {
            return redirect()->back()->with('error', 'La cantidad solicitada excede el stock disponible para algunos productos.');
        }
        // Restar el stock y deshabilitar productos si no se excede el stock
        for ($i = 0; $i < count($id_producto); $i++) {
            $producto = tbl_producto::findOrFail($id_producto[$i]);
            $cantidad_vendida = $cantidad[$i];
            $producto->update(['stock' => $producto->stock - $cantidad_vendida]);
            if ($producto->stock == 0) {
                $producto->update(['estado' => 'DESHABILITADO']);
                // Obtener el nombre del producto
                $nombreProducto = $producto->nombrep;
                // Obtener el ID del vendedor
                $idVendedor = $id_tendero[$i];
                // Verificar si ya se agregó el vendedor al array
                if (!isset($productosSinStockPorVendedor[$idVendedor])) {
                    $productosSinStockPorVendedor[$idVendedor] = [];
                }
                // Agregar el nombre del producto al array correspondiente al vendedor
                $productosSinStockPorVendedor[$idVendedor][] = $nombreProducto;
            }
        }
        // Enviar notificaciones a los vendedores correspondientes
        foreach ($productosSinStockPorVendedor as $idVendedor => $productosSinStock) {
            $vendedor = User::find($idVendedor);
            $vendedor->notify(new ProductosSinStockNotification($productosSinStock));
        }
        // Crear la factura
        $factura = request()->except('id', 'total_prod', 'cantidad', 'id_tendero', '_token');
        $createdFactura = Tbl_Factura::create($factura);
        $id_factura = $createdFactura->id_factura;
        // Guardar los detalles de la factura
        for ($i = 0; $i < count($id_producto); $i++) {
            $idtendero = $id_tendero[$i];
            if (!in_array($idtendero, $vendedoresFacturaPendiente)) {
                $vendedoresFacturaPendiente[] = $idtendero;
            }
            $datasave = [
                'producto_id' => $id_producto[$i],
                'total_producto' => $total_prod[$i],
                'cantidad' => $cantidad[$i],
                'factura_id' => $id_factura,
                'tendero_id' => $id_tendero[$i],
                'estado' => 'PENDIENTE',
            ];
            DB::table('tbl_factura_producto')->insert($datasave);
        }
        foreach ($vendedoresFacturaPendiente as $idtendero) {
            $vendedor = User::find($idtendero);
            $vendedor->notify(new FacturaPendienteNotification($id_factura));
        }
        return redirect()->back()->with('success', 'La compra se registró con éxito!');
    }
#endregion
#region cambiarestado
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
            $facturaCompletada = DB::table('tbl_factura_producto')
                ->where('factura_id', $id)
                ->where('estado', '!=', 'COMPLETADO')
                ->doesntExist();
            if ($facturaCompletada) {
                //Todos los registros de la factura están completados
                event(new \App\Events\FacturasCompletadas($id));
            }
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
#endregion
#region pendiente
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
            ->paginate(12);
        //      //
        if ($facturas->isEmpty()) {
            $error = 'No hay pedidos pendientes';
            return view('templates.estadof.pendientes', compact('facturas','usuario','rol','error'));
        }else{
            return view('templates.estadof.pendientes', compact('facturas','usuario','rol',));
        }
    }
#endregion
#region completado
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
            ->paginate(12);
        //      //
        if ($facturas->isEmpty()) {
            $error = 'No hay pedidos completados';
            return view('templates.estadof.completado', compact('facturas','usuario','rol','error'));
        }else{
            return view('templates.estadof.completado', compact('facturas','usuario','rol',));
        }
    }
#endregion
#region recibo parametrizado
    public function estadisticas(Request $request){
        $fechaActual = Carbon::now();
        // Obtener el mes de la solicitud o el mes actual si no se proporciona
        $mes = $request->input('mes', $fechaActual->month);
        $anio = $request->input('anio', $fechaActual->year);
        //      //
        $top_vendedores = DB::table('tbl_factura_producto')
            ->select('tbl_usuario.id_usuario', 'tbl_usuario.name', DB::raw('SUM(tbl_factura_producto.cantidad) as total_vendido'))
            ->join('tbl_usuario', 'tbl_factura_producto.tendero_id', '=', 'tbl_usuario.id_usuario')
            ->join('tbl_factura', 'tbl_factura.id_factura', '=', 'tbl_factura_producto.factura_id')
            ->whereMonth('tbl_factura.created_at', $mes) // Filtrar por mes (junio)
            ->whereYear('tbl_factura.created_at', $anio) // Filtrar por año (2023)
            ->groupBy('tbl_usuario.id_usuario', 'tbl_usuario.name')
            ->orderByRaw('SUM(tbl_factura_producto.cantidad) DESC')
            ->take(3)
            ->get();
        $top_productos = DB::table('tbl_factura_producto')
            ->select('tbl_producto.id_producto', 'tbl_producto.nombrep','tbl_usuario.name', DB::raw('SUM(tbl_factura_producto.cantidad) as total_vendido'))
            ->join('tbl_producto', 'tbl_factura_producto.producto_id', '=', 'tbl_producto.id_producto')
            ->join('tbl_factura', 'tbl_factura.id_factura', '=', 'tbl_factura_producto.factura_id')
            ->join('tbl_usuario', 'tbl_factura_producto.tendero_id','=','tbl_usuario.id_usuario')
            ->whereMonth('tbl_factura.created_at', $mes) // Filtrar por mes (junio)
            ->whereYear('tbl_factura.created_at', $anio) // Filtrar por año (2023)
            ->groupBy('tbl_producto.id_producto', 'tbl_producto.nombrep', 'tbl_usuario.name')
            ->orderByRaw('SUM(tbl_factura_producto.cantidad) DESC')
            ->take(3)
            ->get();
        $top_clientes = DB::table('tbl_factura')
            ->select('cliente_id', 'tbl_usuario.name', DB::raw('SUM(total) as total_comprado'))
            ->join('tbl_usuario', 'tbl_factura.cliente_id', '=', 'tbl_usuario.id_usuario')
            ->whereMonth('tbl_factura.created_at', $mes) // Filtrar por mes (junio)
            ->whereYear('tbl_factura.created_at', $anio) // Filtrar por año (2023)
            ->groupBy('cliente_id', 'tbl_usuario.name')
            ->orderByRaw('SUM(total) DESC')
            ->take(3)
            ->get();
            //      //
            //Devolver datos a la vista
            if($top_vendedores->isEmpty() && $top_clientes->isEmpty() && $top_productos->isEmpty()){
                $error = 'No se encontraron datos para la fecha solicitada';
                return view('templates.admin.parametrizada', compact('top_vendedores','top_clientes','top_productos','error'));
            }else{
                return view('templates.admin.parametrizada', compact('top_vendedores','top_clientes','top_productos'));
            }
    }
#endregion
}