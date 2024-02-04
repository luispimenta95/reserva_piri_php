<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\HostController;

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

Route::get('/', [HostController::class, 'index']);
Route::post('/post', [PDFController::class, 'store']);
Route::get('/reserva', [HostController::class, 'index']);
Route::post('/iniciar', [HostController::class, 'iniciarReserva']);
Route::post('/hospedes', [HostController::class, 'dadosHospedes']);
Route::post('/teste', [HostController::class, 'dadosHospedes']);
Route::get('/create', function () {
    return view('welcome');
});
