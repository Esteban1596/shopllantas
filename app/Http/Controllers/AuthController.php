<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Evita que un usuario autenticado vea la página de login
        }
        return view('auth.login');
    }

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
 
    // Mostrar el formulario de registro
    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Evita que un usuario autenticado vea la página de registro
        }
        return view('auth.register');
    }

    // Manejar el registro del usuario
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard');
    }

    // Mostrar el formulario de recuperación de contraseña
    public function showResetForm()
    {
        return view('auth.passwords.reset');
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
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
            'token' => 'required',
        ]);

        $response = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill(['password' => Hash::make($password)])->save();
            }
        );

        return $response == Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', 'Tu contraseña ha sido actualizada.')
            : back()->withErrors(['email' => 'No se pudo restablecer tu contraseña.']);
    }
}
