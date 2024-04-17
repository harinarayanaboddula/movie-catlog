<?php

use App\Http\Controllers\MovieController;
use Illuminate\Support\Facades\Route;


Route::get('/', [MovieController::class, 'getMoviesList'])->name('home');
Route::post('/search', [MovieController::class, 'search'])->name('search');

Route::get('/movie', [MovieController::class, 'index'])->name('movie.index');
Route::post('/movie', [MovieController::class, 'store'])->name('movie.store');

Route::get('/movie/{id}/edit', [MovieController::class, 'edit'])->name('movie.edit');
Route::post('/movie/{id}', [MovieController::class, 'update'])->name('movie.update');
Route::post('/movie/{id}/delete', [MovieController::class, 'destroy'])->name('movie.destroy');






