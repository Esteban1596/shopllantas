<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // Mostrar el formulario de registro solo si el usuario es administrador
    public function showRegisterForm()
    {
        if (!Auth::check() || (Auth::user() && Auth::user()->role !== 'admin')) {
            return redirect()->route('login')->with('error', 'No eres administrador, no puedes acceder a esta página.'); // Redirige a login si no es admin
        }

        return view('auth.register');
    }

    // Manejar el registro de un nuevo usuario
    public function register(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard'); 
        }

        // Validación y creación de usuario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('dashboard')->with('success', 'Usuario registrado correctamente.');
    }

    // Mostrar el formulario de login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); 
        }
        return view('auth.login');
    }

    // Manejar el login
    public function login(Request $request)
    {
        
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Verificar si el usuario quiere ser recordado
        $remember = $request->has('remember');

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials, $remember)) {
            return redirect()->route('dashboard');
        }

        // Si falla, mostrar error
        return back()->withErrors(['email' => 'Las credenciales no coinciden con nuestros registros.']);
    }

    // Mostrar el formulario de recuperación de contraseña
    public function showResetForm($token)
    {
        return view('auth.passwords.reset', ['token' => $token]);
    }

    // Enviar el correo de recuperación de contraseña
    public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $response = Password::sendResetLink($request->only('email'));

        return $response == Password::RESET_LINK_SENT
            ? back()->with('status', 'Te hemos enviado un enlace para recuperar tu contraseña.')
            : back()->withErrors(['email' => 'No encontramos ese correo en nuestros registros.']);
    }

    // Mostrar el formulario para restablecer la contraseña
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',  // Laravel necesita esto
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->save();
            }
        );

        // Verificar el estado del restablecimiento de contraseña
        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Contraseña restablecida correctamente.');
        } elseif ($status === Password::INVALID_TOKEN) {
            return back()->withErrors(['token' => 'El enlace de restablecimiento ha expirado o es inválido.']);
        } else {
            return back()->withErrors(['email' => 'No se pudo restablecer la contraseña.']);
        }
    }
}
