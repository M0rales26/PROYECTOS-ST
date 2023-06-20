<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Cart;

class LoginController extends Controller{
    //      //
    public function create(){
        return view('auth.login');
    }
    //      //
    public function store(){
        if (auth()->attempt(request(['email','password'])) == false) {
            return back()->withErrors([
                'message' => 'El correo o contraseña es incorrecto, por favor intente de nuevo!',
            ]);
        }
        $usuario = Auth::user();
        $rolid = $usuario->rol_id;
        if ($rolid == 1) {
            return redirect()->route('shop');
        } elseif ($rolid == 2) {
            return redirect()->route('producto.index');
        } else {
            return redirect()->route('nombres.index');
        }
    }
    //      //
    public function destroy(){
        Cart::clear();
        auth()->logout();
        return redirect()->to('login');
    }
}
