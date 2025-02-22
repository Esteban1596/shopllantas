<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    //
    public function loginSubmit(Request $request)
    {
        // Validar que el correo y la contraseña son correctos
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Verificar si el usuario con el correo existe
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => 'El usuario no está registrado.',
            ]);
        }

        // Intentar autenticar al usuario
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('dashboard');
        }

        // Si la autenticación falla
        return back()->withErrors([
            'password' => 'Las credenciales no son correctas.',
        ]);
    }
}
