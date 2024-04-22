<?php

use App\Http\Controllers\TestController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/dashboard');
});

Route::get('/help', function () {

    return view('help');
});

Route::get('/homeaula', function () {

    return view('homeaula');
});

//Testa se o Laravel tem permissão para criar arquivos no disco
Route::get('/test-storage', [TestController::class, 'testStorage']);

