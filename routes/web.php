<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaterialController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Raiz
Route::get('/', function () {
    return view('login.login');
});

// Autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Painel
Route::get('/painel', [PainelController::class, 'showHome'])->name('home')->middleware('auth');

// Clientes
Route::middleware(['auth'])->group(function () {
    Route::get('/clientes', [ClientesController::class, 'showClientes'])->name('clientes');
    Route::get('/clientes/create', [ClientesController::class, 'showCreateClientes'])->name('clientes.create.form');
    Route::post('/clientes/create', [ClientesController::class, 'createCliente'])->name('clientes.create');
    Route::get('/clientes/edit/{id}', [ClientesController::class, 'showEditClientes'])->name('clientes.edit.form');
    Route::put('/clientes/update/{id}', [ClientesController::class, 'updateCliente'])->name('clientes.update');
});

// Materiais
Route::middleware(['auth'])->group(function () {
    Route::get('/materiais', [MaterialController::class, 'showMaterial'])->name('materiais.index');
    Route::post('/materiais/create', [MaterialController::class, 'createMaterial'])->name('materiais.create');
    Route::put('/materiais/{id}', [MaterialController::class, 'updateMaterial'])->name('materiais.update');
    Route::delete('/materiais/delete/{id}', [MaterialController::class, 'deletarMaterial'])->name('materiais.delete');
});

// Perfil
Route::middleware(['auth'])->group(function () {
    Route::get('/perfil', [MaterialController::class, 'showPerfil'])->name('perfil.index');
    Route::put('/perfil/{id}', [MaterialController::class, 'updatePerfil'])->name('perfil.update');
});

// Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'showAdmin'])->name('admin.index');
    Route::get('/admin/home', [AdminController::class, 'countUsuarios'])->name('admin.index');
    Route::get('/admin/usuarios', [UserController::class, 'showUsuarios'])->name('admin.usuarios.index');
    Route::get('/admin/usuarios/create', [UserController::class, 'showCreateUsuario'])->name('admin.usuarios.create');
    Route::post('/admin/usuarios/create', [UserController::class, 'createUsuario'])->name('admin.usuarios.store');
    Route::get('/admin/usuarios/list', [UserController::class, 'getAllUsuarios'])->name('admin.usuarios.list');
});
