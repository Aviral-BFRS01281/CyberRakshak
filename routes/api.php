<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BehaviourAnalyticsController;
use App\Http\Controllers\DownloadAwbReportController;
use App\Http\Controllers\InsightsController;
use App\Http\Controllers\PiiAccessController;
use App\Http\Controllers\PiiLoggingController;
use App\Http\Controllers\PIIValidationController;
use App\Http\Controllers\SettingController;
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

Route::post('/test', function (\Illuminate\Http\Request $request) {
    return [
        "name" => "Aviral",
        "mobile" => "9888",
        "yoyo" => "zozo"
    ];
})->middleware(\App\Http\Middleware\PiiMiddleware::class);


Route::prefix("internal")->middleware([])->group(function () {
    # Auth
    Route::prefix("auth")->group(function () {
        Route::post("login", [AuthController::class, "login"]);
    });

    # Dashboard[AWB Insights]
    Route::prefix("dashboard")->group(function () {
        Route::get("insights", [InsightsController::class, "show"]);
        Route::get("awbs", [PiiAccessController::class, "index"]);
        Route::get("awbs/{awb}", [PiiAccessController::class, "show"]);
    });

    # Settings
    Route::prefix("settings")->group(function () {
        Route::get("/", [SettingController::class, "getSetting"]);
        Route::post("/update", [SettingController::class, "updateSetting"]);
    });

    # Users
    Route::prefix("users")->group(function () {
        Route::get("{id}/analytics", [BehaviourAnalyticsController::class, "show"]);
    });

    # PII Incident Report
    Route::get("download-awb-report", [DownloadAwbReportController::class, "download"]);
});

Route::prefix("external")->middleware([])->group(function () {
    # PII Validation
    Route::prefix("pii")->group(function () {
        Route::post("check", [PIIValidationController::class, "check"]);
        Route::post("log", [PiiLoggingController::class, "log"]);
        Route::post("awbs/log", [PiiLoggingController::class, "logAwb"]);
    });
});
