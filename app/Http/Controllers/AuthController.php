<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;

class AuthController extends Controller
{
    // Mostrar el formulario de registro solo si el usuario ya está registrado
        public function showRegisterForm()
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return redirect()->route('login')->with('error', 'No eres administrador, no puedes acceder a esta página.'); // Redirige a login si no es admin
        }

        return view('auth.register');
    }

    public function register(Request $request)
    {
        // Verificar si el usuario autenticado tiene rol de 'admin'
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('dashboard'); // Redirige al dashboard si no es admin
        }

        // Validación y creación de usuario
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'user', // Aquí puedes definir si deseas asignar un rol por defecto
        ]);

        // Iniciar sesión automáticamente
        Auth::login($user);

        // Redirigir al dashboard
        return redirect()->route('dashboard');
    }


    // Mostrar el formulario de login
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Evita que un usuario autenticado vea la página de login
        }
        return view('auth.login');
    }

    // Manejar el login
    public function login(Request $request)
    {
        // Validar las credenciales
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Intentar autenticar al usuario
        if (Auth::attempt($credentials)) {
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

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Contraseña restablecida correctamente.')
            : back()->withErrors(['email' => 'No se pudo restablecer la contraseña.']);
    }
}
