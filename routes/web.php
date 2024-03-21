<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});

Route::get('/help', function () {

    return view('help');
});

Route::get('/homeaula', function () {

    return view('homeaula');
});
