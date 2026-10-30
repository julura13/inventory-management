<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ApiController::class, 'index'])->name('api.index');
Route::post('/api/product', [ApiController::class, 'store'])->name('api.store');
Route::put('/api/product', [ApiController::class, 'update'])->name('api.update');
Route::delete('/api/product', [ApiController::class, 'destroy'])->name('api.destroy');

require __DIR__.'/auth.php';
