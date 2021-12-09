<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DocumentController;

Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');

/* Users */

Route::get('/admin/users', [UserController::class, 'index']);

Route::get('/admin/users/create', [UserController::class, 'create']);
Route::post('/admin/users/store', [UserController::class, 'store']);
Route::get('/admin/users/{user}/edit', [UserController::class, 'edit']);
Route::post('/admin/users/{user}/update', [UserController::class, 'update']);
Route::get('/admin/users/{user}/delete', [UserController::class, 'delete']);


/* Documents */
Route::get('/admin/documents', [DocumentController::class, 'index']);

Route::get('/admin/documents/create', [DocumentController::class, 'create']);
Route::post('/admin/documents/store', [DocumentController::class, 'store']);
Route::get('/admin/documents/{document}/edit', [DocumentController::class, 'edit']);
Route::post('/admin/documents/{document}/update', [DocumentController::class, 'update']);
Route::get('/admin/documents/{document}/delete', [DocumentController::class, 'delete']);
Route::get('/admin/documents/{document}/user/{user}/delete', [DocumentController::class, 'user_delete']);
Route::post('/admin/documents/{document}/user/create', [DocumentController::class, 'user_create']);
Route::post('/admin/documents/{document}/user/update', [DocumentController::class, 'user_update']);
Route::post('/admin/documents/{document}/input/create', [DocumentController::class, 'input_create']);
Route::get('/admin/documents/{document}/generate', [DocumentController::class, 'generate_document']);

