<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tbl_Producto;
// use App\Models\Tbl_Producto_Auditoria;
// use Carbon\Carbon;
use Cart;

class CarritoController extends Controller{
    public function shop(Request $request){
        $texto = trim($request->get('texto'));
        $producto = DB::table('tbl_producto')
                    ->select('id_producto','nombrep','precio','peso_neto','foto','estado','tbl_usuario.name')
                    ->join('tbl_usuario','tbl_producto.usuario_id','=','tbl_usuario.id_usuario')
                    ->where('nombrep','LIKE','%'.$texto.'%')
                    ->where('estado','HABILITADO')
                    ->orderBy('precio','asc')
                    ->paginate(12);
        return view('templates.productos', compact('producto','texto'));
    }
    //      //
    public function cart(){
        $cartCollection = Cart::getContent();
        // Verificar el stock de los productos en el carrito
        foreach ($cartCollection as $item) {
            $productId = $item->id;
            $product = tbl_producto::find($productId);
            if ($product->stock == 0) {
                // Eliminar el producto del carrito
                Cart::remove($item->id);
            }
        }
        return view('templates.carrito')->with(['cartCollection'=>$cartCollection]);
    }
    //      //
    public function store(Request $request){
        $productId = $request->products_id;
        $product = tbl_producto::find($productId);
        // Verificar si el producto tiene stock disponible
        if ($product->stock > 0) {
            Cart::add(
                $product->id_producto,
                $product->nombrep,
                $product->precio,
                1,
                array(
                    'imagen' => $product->foto,
                    'descripcion' => $product->contenido_neto,
                    'id_tendero' => $product->usuario_id
                )
            );
            return back()->with('success', 'Producto agregado al carrito.');
        } else {
            return back()->with('error', 'El producto seleccionado no tiene stock disponible.');
        }
    }
    //      //
    public function update(Request $request){
        Cart::update($request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            ));
        return back();
    }
    //      //
    public function remove(Request $request){
        Cart::remove(['id'=>$request->id]);
        return back();
    }
    //      //
    public function clear(){
        Cart::clear();
        return back();
    }
    //      //
}