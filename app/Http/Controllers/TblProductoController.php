<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tbl_Producto;
use App\Models\Tbl_Producto_Auditoria;
use App\Models\Tbl_Listado_Nombresp;
use Illuminate\Support\Facades\DB;

class TblProductoController extends Controller{
    //      //
    public function index(){
        $datos['producto'] = tbl_producto::where('usuario_id', auth()->user()->id_usuario)->get();
        return view('templates.catalogo', $datos);
    }
    //      //
    public function create(){
        $nombres = Tbl_Listado_Nombresp::where('estado','=','HABILITADO')->get();
        return view('templates.producto.create', compact('nombres'));
    }
    //      //
    public function store(Request $request){
        $messages = [
            'nombrep' => [
                'required' => 'El campo "Nombre Producto" es obligatorio.',
            ],
            'precio' => [
                'required' => 'El campo "Precio" es obligatorio.',
                'numeric' => 'En el campo "Precio" solo se permite ingresar números.',
                'not_negative' => 'No sé permite el ingreso de valores negativos.',
            ],
            'stock' => [
                'required' => 'El campo "Stock Producto" es obligatorio.',
                'numeric' => 'En el campo "Stock Producto" solo se permite ingresar números.',
                'greater_than_zero' => 'La cantidad de stock debe ser mayor que 0.',
            ],
            'peso_neto.required' => 'El campo "Contenido Neto" es obligatorio.',
            'foto.required' => 'El campo "Foto Producto" es obligatorio.',
        ];
        $request->validate([
            'nombrep' => 'required',
            'precio' => 'required|numeric|not_negative',
            'peso_neto' => 'required',
            'stock' => 'required|numeric|greater_than_zero',
            'foto' => 'required',
        ],$messages);
        //      //
        $datoscatalogo = request()->except('_token');
        if ($imagen = $request->file('foto')) {
            $rutaguardarimg = 'imgprod/';
            $imagenprod = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaguardarimg, $imagenprod);
            $datoscatalogo['foto'] = $imagenprod;
        }
        //      //
        $name = request()->post('nombrep');
        $user = request()->post('usuario_id');
        if(DB::table('tbl_producto')
            ->where('nombrep', $name)
            ->where('usuario_id',$user)
            ->exists()) {
            return redirect()->back()->with('error', 'El producto ya existe.');
        } else {
            tbl_producto::create($datoscatalogo);
            $producto = tbl_producto::max('id_producto');
            $auditoria = new Tbl_Producto_Auditoria([
                'producto_id' => $producto,
                'usuario_id' => $request->input('usuario_id'),
                'accion' => 'crear',
                'precio'=> $request->input('precio')
            ]);
            $auditoria->save();
            return redirect()->route('producto.index')->with('success', 'El producto ha sido creado.');
        }
    }
    //      //
    public function edit($id){
        $producto = tbl_producto::find($id);
        return view('templates.producto.edit', compact('producto'));
    }
    //      //
    public function update(Request $request, $id){
        $messages = [
            'nombrep' => [
                'max' => 'El nombre debe tener máximo 40 caracteres.',
            ],
            'precio' => [
                'numeric' => 'En el campo "Precio" solo se permite ingresar números.',
                'not_negative' => 'No sé permite el ingreso de valores negativos.',
            ],
            'stock' => [
                'numeric' => 'En el campo "Stock Producto" solo se permite ingresar números.',
                'greater_than_zero' => 'La cantidad de stock debe ser mayor que 0.',
            ],
        ];
        $request->validate([
            'nombrep' => 'max:40',
            'precio' => 'numeric|not_negative',
            'stock' => 'numeric|greater_than_zero',
        ],$messages);
        //      //
        $datoscatalogo = request()->except(['_token', '_method']);
        if ($imagen = $request->file('foto')) {
            $rutaguardarimg = 'imgprod/';
            $imagenprod = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaguardarimg, $imagenprod);
            $datoscatalogo['foto'] = $imagenprod;
        } else {
            unset($datoscatalogo['foto']);
        }
        tbl_producto::where('id_producto', '=', $id)->update($datoscatalogo);
        //      //
        $auditoria = new Tbl_Producto_Auditoria([
            'producto_id' => $id,
            'usuario_id' => $request->input('usuario_id'),
            'accion' => 'actualizar',
            'precio' => $request->input('precio')
        ]);
        $auditoria->save();
        return redirect()->route('producto.index')->with('Actualizado','ok');
    }
    //      //
    // public function destroy($id){
    //     tbl_producto::destroy($id);
    //     return redirect()->route('producto.index')->with('Eliminado','ok');
    // }
    //      //
    public function cambiarestado($id){
        $product = tbl_producto::find($id);
        if ($product->estado == 'HABILITADO'){
            DB::table('tbl_producto')->where('id_producto',$id)->update(['estado'=>'DESHABILITADO']);
            return redirect()->back();
        } else {
            DB::table('tbl_producto')->where('id_producto',$id)->update(['estado'=>'HABILITADO']);
            return redirect()->back();
        }
    }
}
