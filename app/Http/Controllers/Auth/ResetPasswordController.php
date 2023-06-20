<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */
    use ResetsPasswords;
    /**
     * Where to redirect users after resetting their password.
     *return redirect('/login');
     * @var string
     */
    protected $redirectTo = '/login';

    public function reset(Request $request){
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
            //         //
            'password_confirmation.required' => 'El campo "Confirmar Contraseña" es obligatorio.',
        ];
        //      //
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8|max:16',
            'password_confirmation' => 'required',
        ], $messages);
        $response = $this->broker()->reset(
            $this->credentials($request),
            function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );
        //      //
        if ($response == Password::PASSWORD_RESET) {
            $user = Auth::user();
            $rolid = $user->rol_id;
            // Redirección basada en el rol_id del usuario
            if ($rolid == 1) {
                return redirect()->route('shop');
            } elseif ($rolid == 2) {
                return redirect()->route('producto.index');
            } else {
                return redirect()->route('nombres.index');
            }
        } else {
            return back()
            ->withInput($request->only('email'))
            ->withErrors(['email' => trans($response)]);
        }
    }
}