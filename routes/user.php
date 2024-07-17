<?php

use App\Models\User;
use App\Http\Controllers\User\GeneratedQuesController;
use App\Http\Controllers\User\DashboardController;



Route::middleware(['auth', 'user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::controller(GeneratedQuesController::class)->prefix('generated-question')->name('generated_question.')->group(function () {
        Route::get('/', 'index')->name('index');
        Route::get('/show/{id}', 'show')->name('show');
        Route::post('/enroll', 'enroll')->name('enroll');
        Route::post('/store', 'store')->name('store');
    });
});
