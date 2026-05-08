<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class,'index'])->name('posts.index');

Route::get('/create',[PostController::class,'create']);

Route::post('/store',[PostController::class,'store'])->name('posts.store');

// NEW FEATURES
Route::get('/preview/{id}', [PostController::class, 'preview'])->name('posts.preview');