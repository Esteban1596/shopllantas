<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductoController;
use App\Models\Producto;

// Ruta de inicio
Route::get('/', function () {
    return view('welcome');
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
Route::middleware(['auth'])->get('/dashboard', function () {
    $productos = Producto::with('inventarios')->get(); // Cargar productos con su inventario
    return view('dashboard', compact('productos'));
})->name('dashboard');

// Ruta de logout
Route::post('logout', function () {
    Auth::logout();
    return redirect('/');  // Redirige al inicio o a la ruta que prefieras
})->name('logout');

// Rutas de productos
Route::middleware(['auth'])->group(function () {
    Route::get('/productos', [ProductoController::class, 'index'])->name('productos.index');
    Route::post('/productos', [ProductoController::class, 'store'])->name('productos.store');
    
    // Rutas para incrementar y decrementar la cantidad
    Route::post('/productos/{id}/cantidad/increase', [ProductoController::class, 'increaseQuantity']);
    Route::post('/productos/{id}/cantidad/decrease', [ProductoController::class, 'decreaseQuantity']);
});

// Ruta para eliminar producto
Route::delete('/productos/{id}', [ProductoController::class, 'destroy'])->name('productos.destroy');


