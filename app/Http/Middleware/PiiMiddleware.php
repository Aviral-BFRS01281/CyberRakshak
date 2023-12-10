<?php

namespace App\Http\Middleware;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Support\Facades\Cache;

class PiiMiddleware
{
    public function handle($r, $r2)
    {
        return $r2($r);
    }

    public function terminate($req, $resp)
    {
        $url = $req->url();

        info("YOYP");

        $params = array_keys($req->query->all());

        $method = $req->method();

        $ip = $req->ip();

//        $userId = $req->user()->id;

        $userId = 2;

        $fingerprint = sha1(implode('|',
            [$method, $url, implode("|", $params)]
        ));

        $key = "request_fingerprint_{$fingerprint}";

        $body = json_decode($resp->getBody()->getContents());

        if (json_last_error() != JSON_ERROR_NONE)
        {
            # Body is non-json serializable. No point in progressing.

            info("Body is not serializable.");

            return;
        }

        $payload = [
            "url" => $url,
            "verb" => $method,
            "params" => $params,
            "method" => $method,
            "ip" => $ip,
            "user_id" => $userId,
            "body" => $body
        ];

        info("PAYLOAD", $payload);

        if (!Cache::has($key))
        {
            $response = (new Client())->post("http://api.pidash.dev/external/pii/check", [
                RequestOptions::JSON => $payload
            ]);

            $response = json_decode($response->getBody()->getContents(), "true");

            if (($response->score ?? 0) > 0)
            {
                !Cache::put($key, 1, 3600 * 12);

                (new Client())->post("https://api.pidash.dev/external/pii/log", [
                    RequestOptions::JSON => $payload
                ]);
            }
        }

    }
}
