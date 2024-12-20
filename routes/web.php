<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\ClientesController;


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

// Raiz
Route::get('/', function () {
    return view('login.login');
});

// Relacionados ao AuthController
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Relacionados ao PainelController
Route::get('/painel', [PainelController::class, 'showHome'])->name('home')->middleware('auth');

// Relacionados ao ClientesController
Route::get('/clientes', [ClientesController::class, 'showClientes'])->name('clientes')->middleware('auth');
Route::get('/clientes/create', [ClientesController::class, 'showCreateClientes'])->name('clientes.create.form')->middleware('auth');
Route::post('/clientes/create', [ClientesController::class, 'createCliente'])->name('clientes.create')->middleware('auth');


