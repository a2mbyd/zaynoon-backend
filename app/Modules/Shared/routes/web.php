<?php

use Illuminate\Support\Facades\Route;

Route::prefix('shared')->name('shared.')->group(function () {
    Route::get('/', function () {
        return response()->json(['module' => 'Shared', 'status' => 'ok']);
    })->name('index');
});
