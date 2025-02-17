<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DashboardController;
use App\Models\Cliente;

// Redirigir a login en lugar de mostrar 'welcome'
Route::get('/', function () {
    return redirect()->route('login'); // Redirige a la ruta de login
});

// Rutas de autenticación
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::get('password/reset', [AuthController::class, 'showResetForm'])->name('password.request');
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [AuthController::class, 'resetPassword'])->name('password.update');

// Ruta de dashboard protegida por autenticación
Route::middleware(['auth'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Ruta de logout
Route::post('logout', function () {
    Auth::logout();
    return redirect('/');  // Redirige al inicio o a la ruta que prefieras
})->name('logout');

// Rutas de productos y clientes, protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('registro-producto', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('registro-producto', [ProductoController::class, 'store'])->name('productos.store');
    
    Route::get('registro-cliente', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('registro-cliente', [ClienteController::class, 'store'])->name('clientes.store');

    Route::resource('cotizaciones', CotizacionController::class);

});

