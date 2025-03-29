<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Rota para o login
Route::post('/login', [UserController::class, 'login']); 

// Rota para cadastro de usuário
Route::post('/users', [UserController::class, 'store']);  

Route::get('users', [UserController::class, 'listar']); 