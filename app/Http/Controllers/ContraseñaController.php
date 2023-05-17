<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class ContraseñaController extends Controller{
    public function create(Request $request, $token = null){
        return view('auth.contraseña')->with(
            ['token' => $token, 'email' => $request->email]
        );
    }
    //      //
    public function resetPassword(Request $request){
        $messages = [
            'email' => [
                'required' => 'El campo "Correo Electrónico" es obligatorio.',
                'email' => 'La dirección de correo electrónico no es válida.',
            ],
            'password' => [
                'required' => 'El campo "Contraseña" es obligatorio.',
                'confirmed' => 'Los contraseñas ingresadas no coinciden.',
                'max' => 'La contraseña debe tener máximo 16 caracteres.',
                'min' => 'La contraseña debe tener mínimo 8 caracteres.',
            ],
        ];
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|confirmed|max:16|min:8',
        ],$messages);
        //      //
        $user = User::where('email', $request->email)->first();
        //      //
        if (!$user) {
            return redirect()->back()->withErrors([
                'email' => 'No se ha encontrado una cuenta con ese correo electrónico.'
            ]);
        }
        //      //
        $user->password = bcrypt($request->password);
        $user->save();
        return redirect()->route('login.index');
        // Aquí puedes redirigir al usuario a donde quieras después de restablecer la contraseña
    }
}
