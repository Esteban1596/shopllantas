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
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Controllers\VentaController;

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
    return redirect('/');  
})->name('logout');

// Rutas de productos y clientes, protegidas por autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::get('registro-producto', [ProductoController::class, 'create'])->name('productos.create');
    Route::post('registro-producto', [ProductoController::class, 'store'])->name('productos.store');
    Route::delete('productos/{producto}', [ProductoController::class, 'destroy'])->name('productos.destroy');
    
    Route::get('/clientes', [ClienteController::class, 'index'])->name('clientes.index');
    Route::get('registro-cliente', [ClienteController::class, 'create'])->name('clientes.create');
    Route::post('registro-cliente', [ClienteController::class, 'store'])->name('clientes.store');
    Route::delete('clientes/{cliente}', [ClienteController::class, 'destroy'])->name('clientes.destroy');


    Route::resource('cotizaciones', CotizacionController::class);
    Route::get('cotizacion/{id}/descargar', [CotizacionController::class, 'descargarCotizacion'])->name('cotizaciones.descargar');
   
    Route::get('ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::post('ventas', [VentaController::class, 'store'])->name('ventas.store');

});

