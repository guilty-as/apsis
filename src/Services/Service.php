<?php


namespace Guilty\Apsis\Services;

use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;


abstract class Service
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * @var string The date format expected by the APSIS api
     */
    protected $dateFormat = "Ymd\THis";

    /**
     * Resource constructor.
     *
     * @param $client
     */
    function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function responseToJson(ResponseInterface $response)
    {
        $string = $response->getBody()->getContents();
        return json_decode($string, true);
    }
}