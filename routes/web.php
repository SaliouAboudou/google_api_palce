<?php

use App\Http\Controllers\HopitauxController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/search-hopitaux', [HopitauxController::class, 'listeHopitaux'])->name('search_hopitaux');
Route::get('/', [HopitauxController::class, 'index'])->name('index');
Route::get('/cliniques', [HopitauxController::class, 'clinique'])->name('cliniques');
Route::get('/hopitaux', [HopitauxController::class, 'hopitaux'])->name('hopitaux');
