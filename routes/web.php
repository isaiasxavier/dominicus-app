<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/help', function () {

    return view('help');
});

Route::get('/homeaula', function () {

    return view('homeaula');
});
