<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmiController;
use App\Http\Middleware\PreventbackHistory;


Route::prefix('admin')->name('admin.')->group(function(){

    Route::middleware('guest:admin')->group(function(){
        Route::view('/login','back.pages.admin.auth.login')->name('login');
        Route::post('/login_handler',[AdmiController::class, 'login_handler'])->name('login_handler');
    });

    Route::middleware('auth:admin')->group(function(){
        Route::view('/home','back.pages.admin.home')->name('home');
        Route::get('logout_handler',[AdmiController::class,'logout_handler'])->name('logout_handler');
    });
})->middleware(PreventbackHistory::class);