<?php

use Src\Route;

Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup'])->middleware('admin');
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add('GET', '/forbidden', [Controller\Site::class, 'forbidden']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add('GET', '/buildings', [Controller\BuildingsController::class, 'buildings']);
Route::add(['GET', 'POST'], '/create', [Controller\BuildingsController::class, 'create'])->middleware('admin');
Route::add('GET', '/edit/{id}', [Controller\BuildingsController::class, 'edit'])->middleware('admin');
Route::add('POST', '/edit/{id}', [Controller\BuildingsController::class, 'update'])->middleware('admin');
Route::add('GET', '/delete/{id}', [Controller\BuildingsController::class, 'delete'])->middleware('admin');