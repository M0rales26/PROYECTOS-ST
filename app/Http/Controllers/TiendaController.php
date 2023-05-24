<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class TiendaController extends Controller{
    //
    public function index(Request $request){
        $texto = trim($request->get('texto'));
        $tiendas = DB::table('tbl_usuario')
                    ->select('id_usuario','name','email','fotop')
                    ->where('name','LIKE','%'.$texto.'%')
                    ->where('rol_id', 2)
                    ->orderBy('id_usuario','asc')
                    ->paginate(12);
        return view('templates.tiendas.tiendas', compact('tiendas','texto'));
    }
    //
    public function info($id){
        $user['tendero'] = User::where('id_usuario', $id)->get();
        $datos['producto']=DB::table('tbl_producto')
            ->select('id_producto','nombrep','precio','peso_neto','foto','estado','stock')
            ->where('estado','HABILITADO')
            ->where('usuario_id',$id)->get();
        return view('templates.tiendas.infot', $datos, $user);
    }
}
