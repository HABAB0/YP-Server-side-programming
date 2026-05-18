<?php

use Src\Route;

Route::add('GET', '/api', ["Controller\Api", "index"]);
Route::add('POST', '/api/echo', ["Controller\Api", "echo"]);
