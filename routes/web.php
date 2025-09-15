<?php

use App\Http\Controllers\web\BukuWebController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Resource route untuk BukuWebController
Route::resource('buku', BukuWebController::class);