<?php


namespace Zarinpal;

use GuzzleHttp\Client as HttpClient;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Arr;
use Zarinpal\Exceptions\InvalidDataException;

class Client
{
    private $http;

    /**
     * Client constructor.
     *
     * @param bool|null $sandbox_mode
     * @param HttpClient|null $httpClient
     */
    public function __construct(
        bool $sandbox_mode = null,
        HttpClient $httpClient = null
    )
    {
        if ($sandbox_mode)
            $base_uri = 'https://sandbox.zarinpal.com/pg/rest/WebGate/';
        else
            $base_uri = 'https://www.zarinpal.com/pg/rest/WebGate/';

        if ($httpClient)
            $this->http = $httpClient;
        else
            $this->http = new HttpClient([ 'base_uri' => $base_uri ]);
    }

    /**
     * Payment Request
     *
     * @param string $endpoint
     * @param array $data
     *
     * @return mixed
     *
     * @throws InvalidDataException
     */
    public function request (string $endpoint, array $data)
    {
        try {
            $response =
                $this->http->post($endpoint, [
                    'json' => $data
                ]);

            return json_decode($response->getBody());

        } catch (ClientException $exception) {
            $res = json_decode($exception->getResponse()->getBody(), 1);
            $message = data_get($res, 'errors.*.0');
            throw new InvalidDataException(implode(' ', $message), $res['Status'], $res);
        }
    }

}
