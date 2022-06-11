<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\MarcaController;

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

Route::get('/', [MainController::class, 'inicio']);


Route::get('/marca', [MarcaController::class, 'inicio']);
Route::get('/marca/obtenerRegistros', [MarcaController::class, 'obtenerRegistros']);
Route::post('/marca/obtenerMarca', [MarcaController::class, 'obtenerMarca']);
Route::post('/marca/editar', [MarcaController::class, 'editar']);
Route::post('/marca/guardar', [MarcaController::class, 'guardar']);
Route::post('/marca/eliminar', [MarcaController::class, 'eliminar']);

