<?php

use Illuminate\Support\Facades\Route;

Route::prefix('users')->name('users.')->group(function () {
    Route::get('/', function () {
        return response()->json(['module' => 'Users', 'status' => 'ok']);
    })->name('index');
});
