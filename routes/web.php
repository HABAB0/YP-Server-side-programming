<?php

use Src\Route;

Route::add(['GET', 'POST'], '/signup', [Controller\Site::class, 'signup'])->middleware('admin');
Route::add(['GET', 'POST'], '/login', [Controller\Site::class, 'login']);

Route::add('GET', '/hello', [Controller\Site::class, 'hello'])->middleware('auth');
Route::add('GET', '/forbidden', [Controller\Site::class, 'forbidden']);
Route::add('GET', '/logout', [Controller\Site::class, 'logout']);

Route::add('GET', '/buildings', [Controller\BuildingsController::class, 'buildings']);
Route::add(['GET', 'POST'], '/buildings/create', [Controller\BuildingsController::class, 'create'])->middleware('admin');
Route::add(['GET', 'POST'], '/buildings/edit/{id}', [Controller\BuildingsController::class, 'edit'])->middleware('admin');

Route::add('GET', '/buildings/delete/{id}', [Controller\BuildingsController::class, 'delete'])->middleware('admin');

Route::add('GET', '/rooms', [Controller\RoomsController::class, 'rooms']);
Route::add(['GET', 'POST'], '/rooms/create', [Controller\RoomsController::class, 'create'])->middleware('admin');
Route::add('GET', '/rooms/edit/{id}', [Controller\RoomsController::class, 'roomEdit'])->middleware('admin');
Route::add('POST', '/rooms/edit/{id}', [Controller\RoomsController::class, 'roomUpdate'])->middleware('admin');
Route::add('GET', '/rooms/delete/{id}', [Controller\RoomsController::class, 'roomDelete'])->middleware('admin');