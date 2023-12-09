<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
const TIMESTAMP_STANDARD = "Y-m-d H:i:s";


/**
 * Gets all the PII fields with their respective scores.
 *
 * @return int[]
 */
function piiFieldMap() : array
{
    return [
        "name" => 2,
        "mobile" => 10,
        "email" => 5,
        "awb" => 120
    ];
}

/**
 * Generate a unique fingerprint for the request.
 *
 * @param Request $request
 * @return string
 */
function requestFingerprint(Request $request) : string
{
    return sha1(implode('|',
        [$request->method(), $request->route()->uri(), implode("|", array_keys($request->query()))]
    ));
}

function getRequestUrlHash(Request $request, $detected_fields) {
    return sha1(implode('|',
        [$request->method(), implode("|", array_keys($detected_fields))]
    ));
}

function getGenericUrl($url) {
    return preg_replace('/\/(\d+)\/?/', '/*/', $url);
}

function getSrAwbData($awbs) {
    $url = config('endpoints.SR_BASE_URL').config('endpoints.GET_AWB_DATA');
    return Http::get($url, [
        'awb' => $awbs,
        // other parameters as needed
    ]);
}

