<?php

use App\Http\Controllers\PIIValidationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix("external")->middleware([])->group(function () {
    Route::prefix("pii")->group(function () {
        Route::post("check", [PIIValidationController::class, "check"]);
    });
});
