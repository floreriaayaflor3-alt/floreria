<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CrudController;

Route::get('/', function () {
    return view('login');
});

Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout']);

Route::get('/principal', function () {
    if (!session('usuario')) {
        return redirect('/');
    }

    return view('principal');
});

Route::get('/crud/{tipo}', [CrudController::class, 'index']);