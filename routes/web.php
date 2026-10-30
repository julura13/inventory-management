<?php

use App\Http\Controllers\ApiController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/{search?}', [ApiController::class, 'index'])->name('api.index');
Route::post('/api/product', [ApiController::class, 'store'])->name('api.store');

//Route::post('/search/{search?}', [ApiController::class, 'search'])->name('inventory.search');

require __DIR__.'/auth.php';
