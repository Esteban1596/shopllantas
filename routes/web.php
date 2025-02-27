<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\UserController;
use App\Models\Cotizacion;
use App\Models\Producto;
use Illuminate\Http\Request;

// Redirigir a login en lugar de mostrar 'welcome'
Route::get('/', function () {
    return redirect()->route('login'); // Redirige a la ruta de login
});


// Rutas de autenticación
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login'])->name('login.submit');
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register'])->name('register.submit');
Route::get('password/reset', [AuthController::class, 'showRequestForm'])->name('password.request');
Route::get('password/reset/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
// Enviar el correo de recuperación
Route::post('password/email', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

// Restablecer la contraseña con el token
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

    Route::resource('productos', ProductoController::class);
   
    Route::resource('clientes', ClienteController::class);


    Route::resource('cotizaciones', CotizacionController::class);
    Route::get('cotizacion/{id}/descargar', [CotizacionController::class, 'descargarCotizacion'])->name('cotizaciones.descargar');
   
    Route::get('ventas', [VentaController::class, 'index'])->name('ventas.index');
    Route::post('ventas', [VentaController::class, 'store'])->name('ventas.store');
    Route::get('/ventas/{id}', [VentaController::class, 'show'])->name('ventas.show');
    Route::delete('ventas/{id}', [VentaController::class, 'destroy'])->name('ventas.destroy');
    Route::get('/ventas/{id}/descargar', [VentaController::class, 'descargarPDF'])->name('ventas.descargar');
    

    Route::resource('usuarios', UserController::class);
 
    Route::get('/productos/lista', function (Request $request) {
        return response()->json(Producto::all());
    })->name('productos.lista');

});

