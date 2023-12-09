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
        if(isset($request->plateform_slack)) {
            Setting::updateOrCreateSetting('plateform_slack', $request->plateform_slack);
        }

        if(isset($request->plateform_telegram)) {
            Setting::updateOrCreateSetting('plateform_telegram', $request->plateform_telegram);
        }
        
        if(isset($request->plateform_email)) {
            Setting::updateOrCreateSetting('plateform_email', $request->plateform_email);
        }

        if(isset($request->plateform_whatsapp)) {
            Setting::updateOrCreateSetting('plateform_whatsapp', $request->plateform_whatsapp);
        }
        $response = $this->respondWithOkay(['message' => "Setting updated successfully"]);
        return $response;   
    }
}