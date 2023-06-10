<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tbl_Producto;
// use App\Models\Tbl_Producto_Auditoria;
// use Carbon\Carbon;
use Cart;

class ProveedorController extends Controller{

    public function cart(){
        $cartCollection = Cart::getContent();
        return view('templates.proveedor')->with(['cartCollection'=>$cartCollection]);
    }
    //      //
    public function store(Request $request){
        $productId = $request->products_id;
        $product = tbl_producto::find($productId);
        // Verificar si el producto tiene stock disponible
        Cart::add(
            $product->id_producto,
            $product->nombrep,
            $product->precio,
            1,
            array(
                'imagen' => $product->foto,
                'descripcion' => $product->peso_neto,
                'stock' => $product->stock,
                'id_tendero' => $product->usuario_id
            )
        );
        return back()->with('success', 'Producto agregado al carrito.');
    }
    //      //
    public function update(Request $request){
        $validatedData = $request->validate([
            'id' => 'required',
            'quantity' => 'required|numeric|greater_than_zero',
        ]);
        Cart::update($validatedData['id'], [
            'quantity' => [
                'relative' => false,
                'value' => $validatedData['quantity']
            ],
        ]);
        return back();
    }
    //      //
    public function remove(Request $request){
        Cart::remove(['id_producto'=>$request->id]);
        return back();
    }
    //      //
    public function clear(){
        Cart::clear();
        return back();
    }
    //      //
    public function insert(Request $request){
        $id_producto = $request->id;
        $cantidad    = $request->cantidad;
        for ($i = 0; $i < count($id_producto); $i++) {
            $producto = tbl_producto::findOrFail($id_producto[$i]);
            $cantidad_vendida = $cantidad[$i];
            $producto->update(['stock' => $producto->stock + $cantidad_vendida]);
        }
        return redirect()->back()->with('success', 'El pedido se registró con éxito!');
    }
}