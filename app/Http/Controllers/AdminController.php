<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tbl_Listado_Nombresp;
use App\Models\User;

class AdminController extends Controller{
    public function index(){
        $nombres = DB::table('tbl_listado_nombresp')
            ->select('id_nombrep','nombre')
            ->orderBy('nombre','asc')
            ->paginate(20);
        return view('templates.admin.prodname', compact('nombres'));
    }
    //      //
    public function create(){
        return view('templates.admin.create');
    }
    //      //
    public function store(Request $request){
        $messages = [
            'nombre' => [
                'required' => 'El campo "Nombre Producto" es obligatorio.',
                'max' => 'El nombre debe tener máximo 40 caracteres.',
                'no_special_chars' => 'No se permiten caracteres especiales.',
            ],
        ];
        $request->validate([
            'nombre' => 'required|max:40|no_special_chars',
        ],$messages);
        //      //
        $nombre = request()->except('_token');
        $name = request()->post('nombre');
        if(DB::table('tbl_listado_nombresp')
            ->where('nombre', $name)
            ->exists()) {
            return redirect()->back()->with('error', 'El nombre de producto ya existe.');
        } else {
            tbl_listado_nombresp::create($nombre);
            return redirect()->route('nombres.index')->with('success', 'El nombre de producto ha sido creado.');
        }
    }
    //      //
    public function edit($id){
        $nombre = Tbl_Listado_Nombresp::find($id);
        return view('templates.admin.edit', compact('nombre'));
    }
    //      //
    public function update(Request $request, $id){
        $messages = [
            'nombre' => [
                'max' => 'El nombre debe tener máximo 40 caracteres.',
                'no_special_chars' => 'No se permiten caracteres especiales.',
            ],
        ];
        $request->validate([
            'nombre' => 'max:40|no_special_chars',
        ],$messages);
        //      //
        $nombre = request()->except(['_token', '_method']);
        Tbl_Listado_Nombresp::where('id_nombrep', '=', $id)->update($nombre);
        return redirect()->route('nombres.index')->with('Actualizado','ok');
    }
    //      //
    public function destroy($id){
        Tbl_Listado_Nombresp::destroy($id);
        return redirect()->route('nombres.index')->with('Eliminado','ok');
    }
    //      //
    public function indexa(){
        $admins = DB::table('tbl_usuario')
            ->select('id_usuario','name','email','fotop')
            ->where('rol_id', 3)
            ->orderBy('id_usuario','asc')
            ->paginate(12);
        return view('templates.admin.admins', compact('admins'));
    }
    //      //
    public function createa(){
        return view('templates.admin.createa');
    }
    //      //
    public function storea(Request $request){
        $messages = [
            'name' => [
                'required' => 'El campo "Nombre" es obligatorio.',
                'no_special_chars' => 'No se permiten caracteres especiales.',
                'max' => 'El nombre debe tener máximo 30 caracteres.',
            ],
            'rol_id.required' => 'El campo "Elegir Rol" es obligatorio.',
            'fotop.required' => 'El campo "Foto Perfil" es obligatorio.',
            'direccion.required' => 'El campo "Dirección" es obligatorio.',
            'password_confirmation.required' => 'El campo "Confirmar Contraseña" es obligatorio.',
            //         //
            'email' => [
                'required' => 'El campo "Correo Electrónico" es obligatorio.',
                'email' => 'La dirección de correo electrónico no es válida.',
                'unique' => 'La dirección de correo electrónico ya existe .',
            ],
            'password' => [
                'required' => 'El campo "Contraseña" es obligatorio.',
                'confirmed' => 'Los contraseñas ingresadas no coinciden.',
                'max' => 'La contraseña debe tener máximo 16 caracteres.',
                'min' => 'La contraseña debe tener mínimo 8 caracteres.',
            ],
        ];
        $request->validate([
            'name' => 'required|no_special_chars|max:30',
            'email' => 'required|email|unique:tbl_usuario,email',
            'rol_id' => 'required',
            'fotop' => 'required',
            'direccion' => 'required',
            'password' => 'required|confirmed|max:16|min:8',
            'password_confirmation' => 'required',
        ],$messages);

        $datosperfil = request()->except(['password_confirmation','_token']);
        $datosperfil['password'] = bcrypt($request->password);
        if ($imagen = $request->file('fotop')) {
            $rutaguardarimg = 'imguser/';
            $imagenprod = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaguardarimg, $imagenprod);
            $datosperfil['fotop'] = $imagenprod;
        }
        User::create($datosperfil);
        return redirect()->route('admins.index')->with('success', 'El administrador ha sido creado.');
    }
}