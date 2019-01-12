<?php

namespace Guilty\Apsis;


use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;

/**
 * Class Factory.
 *
 * @method \Guilty\Apsis\Services\Account account()
 * @method \Guilty\Apsis\Services\Event event()
 * @method \Guilty\Apsis\Services\Subscriber subscriber()
 * @method \Guilty\Apsis\Services\Open open()
 * @method \Guilty\Apsis\Services\Bounce bounce()
 * @method \Guilty\Apsis\Services\Sms sms()
 * @method \Guilty\Apsis\Services\Filter filter()
 * @method \Guilty\Apsis\Services\Transactional transactional()
 * @method \Guilty\Apsis\Services\Folder folder()
 * @method \Guilty\Apsis\Services\Click click()
 * @method \Guilty\Apsis\Services\MailingList mailingList()
 * @method \Guilty\Apsis\Services\Newsletter newsletter()
 */
class Factory
{
    /**
     * @var \GuzzleHttp\Client
     */
    protected $client;

    /**
     * Factory constructor.
     *
     * @param string $apiKey APSIS API Key
     * @param \GuzzleHttp\ClientInterface|null $client If you wish to override the client
     */
    public function __construct($apiKey, ClientInterface $client = null, $https = true)
    {
        $this->client = $client ?: $this->makeDefaultClient($apiKey, $https);
    }

    /**
     * @param string $apiKey
     * @param null|\GuzzleHttp\ClientInterface $client
     * @return \Guilty\Apsis\Factory
     */
    public static function create($apiKey, $client = null, $https = true)
    {
        return new static($apiKey, $client, $https);
    }


    /**
     * Return an instance of a Service based on the method called.
     *
     * @param string $name
     * @param array $arguments
     *
     * @return \Guilty\Apsis\Services\Service
     */
    public function __call($name, $arguments)
    {
        $resource = 'Guilty\\Apsis\\Services\\' . ucfirst($name);
        return new $resource($this->client);
    }

    public function makeDefaultClient($apiKey, $https = true)
    {
        $baseUri = $https ? 'https://se.api.anpdm.com/' : 'http://se.api.anpdm.com/';

        return new Client(
            [
                'base_uri' => $baseUri,
                'headers' => ['Accept' => 'application/json'],
                'auth' => [$apiKey, '', 'basic']
            ]
        );
    }
}
