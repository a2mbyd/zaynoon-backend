<?php

use Illuminate\Support\Facades\Route;

Route::prefix('catalog')->name('catalog.')->group(function () {
    Route::get('/', function () {
        return response()->json(['module' => 'Catalog', 'status' => 'ok']);
    })->name('index');
});
