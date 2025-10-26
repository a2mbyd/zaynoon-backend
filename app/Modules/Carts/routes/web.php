<?php

use Illuminate\Support\Facades\Route;

Route::prefix('carts')->name('carts.')->group(function () {
    Route::get('/', function () {
        return response()->json(['module' => 'Carts', 'status' => 'ok']);
    })->name('index');
});
