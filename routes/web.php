<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;

Route::get('/', [PostController::class, 'index'])->name('posts.index');
Route::get('/create', [PostController::class, 'create'])->name('posts.create');
Route::post('/store', [PostController::class, 'store'])->name('posts.store');
Route::get('/preview/{id}', [PostController::class, 'preview'])->name('posts.preview');
Route::get('/edit/{id}', [PostController::class, 'edit'])->name('posts.edit');
Route::put('/update/{id}', [PostController::class, 'update'])->name('posts.update');
Route::delete('/delete/{id}', [PostController::class, 'destroy'])->name('posts.destroy');
Route::get('/live-search', [PostController::class, 'liveSearch'])->name('posts.liveSearch');

Route::post('/posts/{id}/auto-save', [PostController::class, 'autoSave'])->name('posts.autosave');
Route::post('/posts/{id}/version/{versionId}/restore', [PostController::class, 'restoreVersion'])->name('posts.version.restore');
Route::post('/posts/{id}/collaborate', [PostController::class, 'collaborate'])->name('posts.collaborate');