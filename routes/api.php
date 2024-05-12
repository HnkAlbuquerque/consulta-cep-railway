<?php

use App\Http\Controllers\EnderecoController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/consultar-cep/{cep}', [EnderecoController::class, 'consultarCep'])->name('consulta')->where('cep','^[0-9]{8}$');
Route::get('/consultar-endereco/{endereco}', [EnderecoController::class, 'consultarEndereco'])->where('endereco','^[A-Za-záàâãéèêíïóôõöúçñÁÀÂÃÉÈÍÏÓÔÕÖÚÇÑ\s]+');;
Route::get('/consultar-uf/{uf}', [EnderecoController::class, 'consultarUf'])->name('uf')->where(['uf' => '^[a-zA-Z]{2}']);;
Route::post('/cadastrar-cep', [EnderecoController::class, 'cadastrar'])->name('cadastrar');
Route::put('/editar-cep', [EnderecoController::class, 'editar'])->name('editar');

