<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/productes', [App\Http\Controllers\ApiController::class, 'productesDisponibles']);
Route::get('/comandaspendientes', [App\Http\Controllers\ApiController::class, 'comandasPendientes']);
Route::get('/comandashechas', [App\Http\Controllers\ApiController::class, 'comandasHechas']);
Route::get('/comandasentregadas', [App\Http\Controllers\ApiController::class, 'comandasEntregadas']);