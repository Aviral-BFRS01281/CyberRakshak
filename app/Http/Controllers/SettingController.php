<?php

namespace App\Http\Controllers;

use App\Actions\AnalyzePayload;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\Request as Requests;
use Throwable;
use App\Models\Setting;
class SettingController extends APIController
{
    public function getSetting(Request $request) {
        $settings = Setting::getSettings();
        $response = $this->respondWithOkay(['data' => $settings]);
       return $response;
    }
    public function updateSetting(Request $request) {
        if(empty($request->key)) {
            return $this->respondWithBadRequest([
                "message" => "key not found"
            ]);
        }
        Setting::updateOrCreateSetting($request->key, $request->value);
        $response = $this->respondWithOkay(['message' => "Setting updated successfully"]);
        return $response;   
    }
}