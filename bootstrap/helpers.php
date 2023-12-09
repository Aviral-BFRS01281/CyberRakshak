<?php

use GuzzleHttp\Client;
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

function getRequestUrlHash($payload, $detected_fields) {
    return sha1(implode('|',
        [getGenericUrl($payload['url']), $payload['method'], $payload['query']]
    ));
}

function getGenericUrl($url)
{
    return preg_replace('/\/(\d+)\/?/', '/*/', $url);
}

function getSrAwbData($awbs)
{
    $url = config('endpoints.SR_BASE_URL') . config('endpoints.GET_AWB_DATA');
    return Http::get($url, [
        'awb' => $awbs,
        // other parameters as needed
    ]);
}

function sendSlackMultipleNotification($message, $channelName)
{
    $client = new Client();
    $url = config('services.slack.url'); // Make sure to set up the Slack URL in your config

    $response = $client->post($url, [
        'headers' => [
            'Content-Type' => 'application/json',
            'Authorization' => 'Bearer ' . config('services.slack.token'), // Set up the Slack API token in your config
        ],
        'json' => [
            'channel' => $channelName,
            'text' => $message,
        ],
    ]);

    // Check the response if needed
    $statusCode = $response->getStatusCode();
    if ($statusCode === 200)
    {
        \Log::info("Slack notification sent to channel successfully: $message");
    }
    else
    {
        \Log::error("Failed to send Slack notification. Status code: $statusCode");
    }
}

function getUserDetails(int $userId) : array
{
    # return user details

    return [

    ];
}

function past(int $days = 1) : \Illuminate\Support\Carbon
{
    return now()->subDays($days);
}

function sendTelegramMessage($chatId, $message) {
    try {
        $botToken = config("endpoints.TELEGRAM_BOT_TOKEN");
        $base_url = config("endpoints.TELEGRAM_API_BASE_URL");
        $url = $base_url."/bot".$botToken."/sendMessage?";
        $params = ['chat_id' => $chatId, 'text' => $message];
        \Log::info("sendTelegramMessage", ['botToken' => $botToken, 'base_url' => $base_url, 'url' => $url]);
        $response = file_get_contents($url . http_build_query($params) );
      /*  $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        $response = curl_exec($ch);
        $result = json_decode($response, true);
        if (!empty($result['ok'])) {
            \Log::info('Message sent successfully!' . PHP_EOL);
        } else {
            \Log::info('Failed to send message Error '.$result['description']);
        }
        curl_close($ch); */
    }catch(\Exception $e) {
        \Log::info("sendTelegramMessage_error",[
            'trace' => $e->getTrace(),
            'message' => $e->getMessage()
        ]);
    }
}