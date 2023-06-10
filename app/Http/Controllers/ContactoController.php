<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;
use App\Notifications\MensajeTenderoNotification;
use Illuminate\Support\Facades\Auth;

class ContactoController extends Controller{
    public function index(){
        return view('templates.contacto');
    }
    //      //
    public function enviarcorreo(Request $request){
        $correos = User::where('rol_id', 3)->pluck('email')->toArray();
        $users = User::whereIn('email', $correos)->get();
        $texto = $request->input('texto');
        $senderName = $request->input('name');
        //      //
        Notification::send($users, new MensajeTenderoNotification($texto, $senderName));
        return redirect()->back();
    }
}

