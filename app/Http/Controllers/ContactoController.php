<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\MiCorreo;
use Illuminate\Contracts\Mail\Mailable;

class ContactoController extends Controller{
    public function index(){
        return view('templates.contacto');
    }
    //      //
    public function enviarcorreo(Request $request){
        $correos = User::where('rol_id', 3)->pluck('email')->toArray();
        $texto = $request->input('texto');

        foreach ($correos as $correo) {
            Mail::to($correo)->send(new MiCorreo($texto));
        }
        return redirect()->back();
    }

}

