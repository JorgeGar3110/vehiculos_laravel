<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\ColorController;
use App\Http\Controllers\MarcaController;
use App\Http\Controllers\PropietariosController;
use App\Http\Controllers\VehiculosController;
use App\Http\Controllers\ReportesController;

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


Route::get('/marcas', [MarcaController::class, 'inicio']);
Route::get('/marcas/obtenerRegistros', [MarcaController::class, 'obtenerRegistros']);
Route::post('/marcas/obtenerMarca', [MarcaController::class, 'obtenerMarca']);
Route::post('/marcas/editar', [MarcaController::class, 'editar']);
Route::post('/marcas/guardar', [MarcaController::class, 'guardar']);
Route::post('/marcas/eliminar', [MarcaController::class, 'eliminar']);


Route::get('/colores', [ColorController::class, 'inicio']);
Route::get('/colores/obtenerRegistros', [ColorController::class, 'obtenerRegistros']);
Route::post('/colores/obtenerColor', [ColorController::class, 'obtenerColor']);
Route::post('/colores/editar', [ColorController::class, 'editar']);
Route::post('/colores/guardar', [ColorController::class, 'guardar']);
Route::post('/colores/eliminar', [ColorController::class, 'eliminar']);

Route::get('/propietarios', [PropietariosController::class, 'inicio']);
Route::get('/propietarios/obtenerRegistros', [PropietariosController::class, 'obtenerRegistros']);
Route::post('/propietarios/obtenerPropietario', [PropietariosController::class, 'obtenerPropietario']);
Route::post('/propietarios/editar', [PropietariosController::class, 'editar']);
Route::post('/propietarios/guardar', [PropietariosController::class, 'guardar']);
Route::post('/propietarios/eliminar', [PropietariosController::class, 'eliminar']);

Route::get('/vehiculos', [VehiculosController::class, 'inicio']);
Route::get('/vehiculos/obtenerRegistros', [VehiculosController::class, 'obtenerRegistros']);
Route::post('/vehiculos/obtenerVehiculo', [VehiculosController::class, 'obtenerVehiculo']);
Route::post('/vehiculos/editar', [VehiculosController::class, 'editar']);
Route::post('/vehiculos/guardar', [VehiculosController::class, 'guardar']);
Route::post('/vehiculos/eliminar', [VehiculosController::class, 'eliminar']);

Route::get('/reportes', [ReportesController::class, 'inicio']);
Route::get('/reportes/obtenerRegistros', [ReportesController::class, 'obtenerRegistros']);
Route::post('/reportes/obtenerReporte', [ReportesController::class, 'obtenerReporte']);
Route::post('/reportes/editar', [ReportesController::class, 'editar']);
Route::post('/reportes/guardar', [ReportesController::class, 'guardar']);
Route::post('/reportes/eliminar', [ReportesController::class, 'eliminar']);

