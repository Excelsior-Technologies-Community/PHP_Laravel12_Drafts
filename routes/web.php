<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class,'index'])->name('posts.index');

Route::get('/create', [PostController::class,'create']);

Route::post('/store', [PostController::class,'store'])->name('posts.store');

// PREVIEW FEATURE
Route::get('/preview/{id}', [PostController::class, 'preview'])->name('posts.preview');

// EDIT & UPDATE FEATURES
Route::get('/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/update/{id}', [PostController::class, 'update'])->name('posts.update');

// DELETE FEATURE
Route::delete('/delete/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

// LIVE SEARCH (AJAX)
Route::get('/live-search', [PostController::class, 'liveSearch'])->name('posts.liveSearch');