<?php

use Src\Route;

Route::add('GET', '/api', ["Controller\Api", "index"]);
Route::add('POST', '/api/auth', ["Controller\Api", "auth"]);
Route::add('GET', '/api/buildings', ["Controller\Api", "buildings"])->middleware('bearer');
Route::add('GET', '/api/buildings/{id}', ["Controller\Api", "building"])->middleware('bearer');
Route::add('POST', '/api/buildings', ["Controller\Api", "createBuilding"])->middleware('bearer');
Route::add('PUT', '/api/buildings/{id}', ["Controller\Api", "updateBuilding"])->middleware('bearer');
Route::add('DELETE', '/api/buildings/{id}', ["Controller\Api", "deleteBuilding"])->middleware('bearer');
