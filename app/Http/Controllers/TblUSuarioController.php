<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tbl_Rol;

class TblUSuarioController extends Controller{
    //      //
    public function create(){
        $roles = Tbl_Rol::whereIn('id_rol', [1, 2])->get();
        return view('auth.register', compact('roles'));
    }
    //      //
    public function store(Request $request){
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

        if ($request->rol_id == 2 && User::where('rol_id', 2)->where('name', $request->name)->count() > 0) {
        return redirect()->back()->withErrors(['name' => 'Ya existe un tendero y/o tienda con el mismo nombre ']);
    }

        $datosperfil = request()->except(['password_confirmation','_token']);
        $datosperfil['password'] = bcrypt($request->password);
        if ($imagen = $request->file('fotop')) {
            $rutaguardarimg = 'imguser/';
            $imagenprod = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaguardarimg, $imagenprod);
            $datosperfil['fotop'] = $imagenprod;
        }
        User::create($datosperfil);
        return redirect()->to('/');
    }
    //      //
    public function read($id){
        $datosperfil = User::find($id);
        return view('templates.perfil', compact('datosperfil'));
    }
    //      //
    public function edit($id){
        $datosperfil = User::find($id);
        return view('auth.edit', compact('datosperfil'));
    }
    //      //
    public function update(Request $request, $id){
        $messages = [
            'name' => [
                'no_special_chars' => 'No sé permiten caracteres especiales.',
                'max' => 'El nombre debe tener máximo 30 caracteres.',
            ],
        ];
        //      //
        $request->validate([
            'name' => 'no_special_chars|max:30',
        ],$messages);
        //      //
        $datosperfil = request()->except(['_token', '_method']);
        //      //
        if ($imagen = $request->file('fotop')) {
            $rutaguardarimg = 'imguser/';
            $imagenprod = date('YmdHis') . "." . $imagen->getClientOriginalExtension();
            $imagen->move($rutaguardarimg, $imagenprod);
            $datosperfil['fotop'] = $imagenprod;
        } else {
            unset($datosperfil['fotop']);
        }
        //      //
        User::where('id_usuario', '=', $id)
            ->update($datosperfil);
        //      //
        return redirect()->route('register.read',$id)->with('Actualizado','ok');
    }
}