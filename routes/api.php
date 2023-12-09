<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\InsightsController;
use App\Http\Controllers\PiiAccessController;
use App\Http\Controllers\PiiLoggingController;
use App\Http\Controllers\PIIValidationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GenerateCsvController;

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
Route::prefix("internal")->middleware([])->group(function () {
    # Auth
    Route::prefix("auth")->group(function () {
        Route::post("login", [AuthController::class, "login"]);
    });

    # Dashboard[AWB Insights]
    Route::prefix("dashboard")->group(function () {
        Route::get("insights", [InsightsController::class, "show"]);
        Route::get("awbs/{awb}", [PiiAccessController::class, "show"]);
    });

    Route::get("generate-csv", [GenerateCsvController::class, "generateCsv"]);

});

Route::prefix("external")->middleware([])->group(function () {

    # PII Validation
    Route::prefix("pii")->group(function () {
        Route::post("check", [PIIValidationController::class, "check"]);
        Route::post("log", [PiiLoggingController::class, "log"]);
        Route::post("awbs/log", [PiiLoggingController::class, "logAwb"]);
    });

});

