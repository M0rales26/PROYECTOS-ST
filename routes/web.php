<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoController;
use App\Http\Controllers\ComparacionController;
use App\Http\Controllers\ContactoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\TiendaController;
use App\Http\Controllers\TblUSuarioController;
use App\Http\Controllers\TblProductoController;
use App\Http\Controllers\TblFacturaController;
use App\Http\Controllers\ProveedorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){return view('templates.home');})
    ->middleware('auth')
    ->name('home.index');
//-----------------------------------------------------------//
Route::get('/login',[LoginController::class, 'create'])
    ->middleware('guest')
    ->name('login.index');
Route::post('/login',[LoginController::class, 'store'])
    ->name('login.store');
//-----------------------------------------------------------//
Route::get('/registro',[TblUsuarioController::class, 'create'])
    ->middleware('guest')
    ->name('register.index');
Route::post('/registro',[TblUsuarioController::class, 'store'])
    ->middleware('guest')
    ->name('register.store');
Route::get('/perfil/{id}',[TblUsuarioController::class, 'read'])
    ->middleware('auth')
    ->name('register.read');
Route::get('/editar/{id}',[TblUsuarioController::class, 'edit'])
    ->middleware('auth')
    ->name('register.edit');
Route::put('/editar/{id}',[TblUsuarioController::class, 'update'])
    ->middleware('auth')
    ->name('register.update');
//-----------------------------------------------------------//
Route::resource('producto', TblProductoController::class)
    ->middleware('auth');
//-----------------------------------------------------------//
Route::get('/productos', [CarritoController::class, 'shop'])
    ->middleware('auth')
    ->name('shop');
Route::get('/carrito', [CarritoController::class, 'cart'])
    ->middleware('auth')
    ->name('cart.index');
Route::post('/add', [CarritoController::class, 'store'])
    ->middleware('auth')
    ->name('cart.store');
Route::post('/update', [CarritoController::class, 'update'])
    ->middleware('auth')
    ->name('cart.update');
Route::post('/remove', [CarritoController::class, 'remove'])
    ->middleware('auth')
    ->name('cart.remove');
Route::post('/clear', [CarritoController::class, 'clear'])
    ->middleware('auth')
    ->name('cart.clear');
//-----------------------------------------------------------//
Route::get('historial/',[TblFacturaController::class, 'historial'] )
    ->middleware('auth')
    ->name('historial.index');
Route::post('factura/',[TblFacturaController::class, 'store'] )
    ->middleware('auth')
    ->name('factura.save');
Route::get('factura/pdf',[TblFacturaController::class, 'pdf'] )
    ->middleware('auth')
    ->name('factura.pdf');
Route::get('factura/{id}/pdf',[TblFacturaController::class, 'pdf2'] )
    ->middleware('auth')
    ->name('factura.pdf2');
Route::get('historial/{id}/pdf',[TblFacturaController::class, 'pdfhistorial'] )
    ->middleware('auth')
    ->name('historial.pdf');
//-----------------------------------------------------------//
Route::get('facturas/pendientes',[TblFacturaController::class, 'pendiente'] )
    ->middleware('auth')
    ->name('pendiente.index');
Route::get('facturas/completados',[TblFacturaController::class, 'completado'] )
    ->middleware('auth')
    ->name('completado.index');
//-----------------------------------------------------------//
Route::get('/comparar', [ComparacionController::class, 'comparar'])
    ->middleware('auth')
    ->name('comparar');
Route::get('grafica/producto/{id}',[ComparacionController::class, 'grafica'])
    ->middleware('auth')
    ->name('grafica.producto');
//-----------------------------------------------------------//
Route::get('tiendas', [TiendaController::class, 'index'])
    ->middleware('auth')
    ->name('tiendas.index');
Route::get('tienda/{id}', [TiendaController::class, 'info'])
    ->middleware('auth')
    ->name('tiendainfo.index');
//-----------------------------------------------------------//
Route::get('estado/producto/{id}',[TblProductoController::class, 'cambiarestado'])
    ->middleware('auth')
    ->name('change.status');
Route::get('estado/nombrep/{id}',[AdminController::class, 'cambiarestado'])
    ->middleware('auth')
    ->name('change.status.name');
Route::get('estado/factura/{id}',[TblFacturaController::class, 'cambiarestado'])
    ->middleware('auth')
    ->name('change.status.fact');
//-----------------------------------------------------------//
Route::resource('nombres', AdminController::class)
    ->middleware('auth');
Route::get('admins/listado', [AdminController::class, 'indexa'])
    ->middleware('auth')
    ->name('admins.index');
Route::get('admins/crear', [AdminController::class, 'createa'])
    ->middleware('auth')
    ->name('admins.create');
Route::post('admins/crear', [AdminController::class, 'storea'])
    ->middleware('auth')
    ->name('admins.store');
//-----------------------------------------------------------//
Route::get('contacto', [ContactoController::class, 'index'])
    ->middleware('auth')
    ->name('contacto.index');
Route::post('/contacto',[ContactoController::class, 'enviarcorreo'])
    ->middleware('auth')
    ->name('enviar.correo');
//-----------------------------------------------------------//
Route::get('/logout',[LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('login.destroy');
//----------------------------------------------------------//
// Auth::routes();
Route::get('password/reset', 'App\Http\Controllers\Auth\ForgotPasswordController@showLinkRequestForm')
    ->name('password.request');
// Enviar correo electrónico con el enlace de restablecimiento de contraseña
Route::post('password/email', 'App\Http\Controllers\Auth\ForgotPasswordController@sendResetLinkEmail')
    ->name('password.email');
// Mostrar formulario para restablecer la contraseña
Route::get('password/reset/{token}', 'App\Http\Controllers\Auth\ResetPasswordController@showResetForm')
    ->name('password.reset');
// Actualizar la contraseña
Route::post('password/reset', 'App\Http\Controllers\Auth\ResetPasswordController@reset')
    ->name('password.update');
//-----------------------------------------------------------//
Route::get('/proveedor', [ProveedorController::class, 'cart'])
    ->middleware('auth')
    ->name('proveedor.index');
Route::post('/proveedor/add', [ProveedorController::class, 'store'])
    ->middleware('auth')
    ->name('proveedor.store');
Route::post('/proveedor/update', [ProveedorController::class, 'update'])
    ->middleware('auth')
    ->name('proveedor.update');
Route::post('/proveedor/remove', [ProveedorController::class, 'remove'])
    ->middleware('auth')
    ->name('proveedor.remove');
Route::post('/proveedor/clear', [ProveedorController::class, 'clear'])
    ->middleware('auth')
    ->name('proveedor.clear');
Route::post('/proveedor/insert', [ProveedorController::class, 'insert'])
    ->middleware('auth')
    ->name('proveedor.insertar');
//-----------------------------------------------------------//
Route::get('/estadisticas', [TblFacturaController::class, 'estadisticas'])
    ->middleware('auth')
    ->name('parametrizado.index');
//-----------------------------------------------------------//