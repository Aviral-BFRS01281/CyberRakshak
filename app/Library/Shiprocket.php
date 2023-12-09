<?php

namespace App\Library;

use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Symfony\Component\HttpFoundation\Response;

/**
 * Shiprocket API wrapper
 *
 * @author Aviral Singh<aviral.singh@shiprocket.com>
 */
class Shiprocket
{
    /**
     * The Authentication token to be sent along with request.
     *
     * @var string|null
     */
    protected ?string $token;

    /**
     * The base url to form endpoints.
     *
     * @var string|null
     */
    protected ?string $baseUrl;

    /**
     * GuzzleHttp client instance to be used to make API calls.
     *
     * @var Client
     */
    protected Client $client;

    /**
     * Whether to include the raw message body (not decoded) in response object.
     *
     * @var bool
     */
    static bool $showRawBodyInResponsePayload = true;

    public function __construct()
    {
        $this->token = config("app.shiprocket_webhook_token", env("SHIPROCKET_WEBHOOK_TOKEN"));

        $this->baseUrl = env('PRODUCTION_URL') . "v1";

        $this->client = new Client([
            RequestOptions::HTTP_ERRORS => false
        ]);
    }

    /**
     * Get the token used for authentication.
     *
     * @return string|null
     */
    public function getToken() : ?string
    {
        return $this->token;
    }

    /**
     * Call the given API and return the details.
     *
     * @param string $path
     * @param array $parameters
     * @param string $method
     * @return object
     */
    protected function call(string $path, array $parameters, string $method = "GET") : object
    {
        $url = vsprintf("%s/%s", [$this->baseUrl, $path]);

        try
        {
            $response = $this->client->request($method, $url, [
                RequestOptions::HEADERS => $this->getHeaders(),
                RequestOptions::JSON => $parameters
            ]);

            $body = $response->getBody()->getContents();

            $response = (object)[
                "code" => $response->getStatusCode(),
                "raw" => $body,
                "array" => static::$showRawBodyInResponsePayload ? json_decode($body, true) : null
            ];
        }
        catch (\Throwable $e)
        {
            $response = (object)[
                "code" => Response::HTTP_INTERNAL_SERVER_ERROR,
                "raw" => null,
                "array" => []
            ];
        }

        info("REQUEST_LOG", [
            "url" => $url,
            "params" => $parameters,
            "method" => $method,
            "headers" => $this->getHeaders(),
            "response" => $response
        ]);

        return $response;
    }

    /**
     * Get the headers to be sent along-with the request.
     *
     * @return null[]|string[]
     */
    protected function getHeaders() : array
    {
        return [
            "Authorization" => $this->getToken()
        ];
    }

    public function getInternalUserStatistics() : object
    {
        return $this->call("get-user-statistics", []);
    }

    public function getUserDetails(array $userIds) : object
    {
        return $this->call("get-user-details", $userIds);
    }
}
