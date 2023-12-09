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
        $data = $request->all();
        foreach($data as $setting) {
            foreach($setting as $key => $value) {
                Setting::updateOrCreateSetting($key, $value);
            }
        }
        $response = $this->respondWithOkay(['message' => "Setting updated successfully"]);
        return $response;   
    }
}