<?php

use Illuminate\Support\Facades\Route;

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

/* Route::get('/', function () {
    return view('home');
}); */

Auth::routes();
Route::get('/politica', function () {
  return view('politica');
});
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/solicitar', [App\Http\Controllers\HomeController::class, 'solicitar']);

Route::get('cesta/confirmar', [App\Http\Controllers\CistellaController::class, 'crearComanda'])->middleware("auth");
Route::resource('cesta', App\Http\Controllers\CistellaController::class)->middleware("auth");
Route::get('comandas/entregadas', [App\Http\Controllers\ComandaController::class, "entregadas"])->middleware("auth");
Route::put('comandas/entregadas/{id}', [App\Http\Controllers\ComandaController::class, "noentregada"])->middleware("auth");
Route::resource('comandas', App\Http\Controllers\ComandaController::class)->middleware("auth");
Route::resource('user', App\Http\Controllers\UserController::class)->middleware("admin");
Route::resource('disponibles', App\Http\Controllers\DisponibleController::class)->middleware("auth");
Route::get('gestionproductos/eliminados', [App\Http\Controllers\ProducteController::class, "eliminados"])->middleware("admin");
Route::put('gestionproductos/eliminados/{id}', [App\Http\Controllers\ProducteController::class, "volveractivar"])->middleware("admin");
Route::get('gestionproductos/imagenes', [App\Http\Controllers\ProducteController::class, "imagenes"])->middleware("admin");
Route::post('gestionproductos/imagenes/create', [App\Http\Controllers\ProducteController::class, "imagenescrear"])->middleware("admin");
Route::delete('gestionproductos/imagenes/delete/{id}', [App\Http\Controllers\ProducteController::class, "imageneseliminar"])->middleware("admin");

Route::resource('productos', App\Http\Controllers\ProducteController::class);
Route::resource('imagenes', App\Http\Controllers\ProducteImatgeController::class)->middleware("auth");
Route::get('/gestionproductos', [App\Http\Controllers\ProducteController::class, 'gestioproductes'])->middleware('admin')->name('gestioproductes');
Route::get('/gestionusuarios', [App\Http\Controllers\UserController::class, 'index'])->middleware('admin')->name('gestiousuaris');
Route::get('/gestiocomandas', [App\Http\Controllers\ComandaController::class, 'index'])->name('gestiocomandes');

/*    'comandas' => App\Http\Controllers\ComandaController::class,
    'user' => App\Http\Controllers\Controller::class,
    'productos' => App\Http\Controllers\ProducteController::class,
    'imagenes' => App\Http\Controllers\ProducteImatgeController::class,
    'disponibles' => App\Http\Controllers\DisponibleController::class,
)
  */
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
