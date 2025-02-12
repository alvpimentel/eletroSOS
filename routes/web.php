<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PainelController;
use App\Http\Controllers\ClientesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\ServicoController;
use App\Http\Controllers\ContratoController;
use App\Models\Contrato;

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
Route::get('/cadastro/usuario', [UserController::class, 'showCadastroForm'])->name('cadastro.usuario');
Route::post('/cadastro/usuario', [UserController::class, 'createUsuarioCadastro'])->name('usuarios.store');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Painel
Route::middleware(['auth'])->group(function () {
Route::get('/painel', [PainelController::class, 'showHome'])->name('home');
Route::get('/painel', [ServicoController::class, 'dashboard'])->name('painel.index');
});

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

// Servicos
Route::middleware(['auth'])->group(function () {
    Route::get('/servicos', [ServicoController::class, 'showServicos'])->name('servicos');
    Route::get('/servicos/create', [ServicoController::class, 'showCreateServico'])->name('servicos.create.form');
    Route::post('/servicos/create', [ServicoController::class, 'createServico'])->name('servicos.create');
    Route::get('/servicos/edit/{id}', [ServicoController::class, 'showEditServico'])->name('servicos.edit');
    Route::put('/servicos/update/{id}', [ServicoController::class, 'editServico'])->name('servicos.update');
    Route::delete('/servicos/delete/{id}', [ServicoController::class, 'deleteServico'])->name('servicos.delete');    
});

// Contratos
Route::middleware(['auth'])->group(function () {
    Route::get('/servicos/{id}/contratos', [ContratoController::class, 'buildContrato'])->name('contratos.gerar');
    Route::post('/contratos/create', [ContratoController::class, 'createContrato'])->name('contratos.create');
    Route::get('/contratos/show/{id}', [ContratoController::class, 'showContrato'])->name('contratos.view');
});

// Companhia
Route::get('/cadastro/companhia', [CompanyController::class, 'showCompanyForm'])->name('cadastro.companhia');
Route::post('/cadastro/companhia', [CompanyController::class, 'store'])->name('companies.store');

// Admin
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/home', [AdminController::class, 'showAdmin'])->name('admin.index');
    Route::get('/admin/home', [AdminController::class, 'countUsuarios'])->name('admin.index');
    Route::get('/admin/usuarios', [UserController::class, 'showUsuarios'])->name('admin.usuarios.index');
    Route::get('/admin/usuarios/create', [UserController::class, 'showCreateUsuario'])->name('admin.usuarios.create');
    Route::post('/admin/usuarios/create', [UserController::class, 'createUsuario'])->name('admin.usuarios.store');
    Route::get('/admin/usuarios/list', [UserController::class, 'getAllUsuarios'])->name('admin.usuarios.list');
});
