<?php

use App\Http\Controllers\UpdateController;

/*
|--------------------------------------------------------------------------
| Update Routes
|--------------------------------------------------------------------------
|
| This route is responsible for handling the intallation process
|
|
|
*/


Route::get('/', [UpdateController::class,'step0']);
