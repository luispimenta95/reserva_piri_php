<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HostController as Host;
use App\Http\Controllers\AppController as App;
use App\Http\Controllers\ReservaController as Reserva;
use App\Http\Controllers\AdminController as Admin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [App::class, 'login']);
Route::get('/iniciar', [Host::class, 'index']);
Route::post('/salvar-reserva', [Host::class, 'receberDados']);
Route::get('/reservas', [Reserva::class, 'show']);
Route::get('/gerar-contrato/{id}', [App::class, 'gerarContrato']);
Route::get('/admin', [Admin::class, 'index']);
Route::get('/lista-reservas', [Admin::class, 'listaReservas']);
