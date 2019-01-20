<?php


namespace Guilty\Apsis\Helper;

use GuzzleHttp\Client;

class QueuedMethodHelper
{
    // State constants, taken from the docs:
    // http://se.apidoc.anpdm.com/Help/QueuedMethods/About%20queued%20methods
    const STATE_WAITING = "Waiting";
    const STATE_STARTED = "Started";
    const STATE_COMPLETED = "Completed";
    const STATE_ERROR = "Error";
    const STATE_FATAL_ERROR = "FatalError";
    const STATE_REJECTED = "Rejected_ToOld";

    /**
     * @var string|null The url which will be polled for the state of the queued method.
     */
    protected $pollUrl = null;

    /**
     * @var string|null The url where the completed dataset can be found once the queued method has completed.
     */
    protected $dataUrl = null;

    /**
     * @var bool Whether or not the data is ready to be retrieved
     */
    protected $isDataReady = false;

    public function __construct($pollUrl, Client $client = null)
    {
        $this->pollUrl = $pollUrl;
        $this->client = $client ?: new Client();
    }

    public static function make($pollUrl, Client $client = null)
    {
        return new static($pollUrl, $client);
    }

    public static function fromJson($json, Client $client = null)
    {
        return new static($json["Result"]["PollURL"], $client);
    }

    /**
     * Poll the pollUrl to check for the latest status of the queued method.
     * use $this->isDataReady() to check if the data is ready after this method.
     *
     * @throws \Exception
     */
    public function poll()
    {
        if ($this->isDataReady === true) {
            // Skip the poll if we already have the data.
            return;
        }

        $response = $this->client->request("get", $this->pollUrl);
        $json = json_decode($response->getBody()->getContents(), true);

        switch ($json["StateName"]) {
            case self::STATE_WAITING:
            case self::STATE_STARTED:
                // Do nothing.. for now
                break;

            case self::STATE_COMPLETED:
                $this->onCompleted($json);
                break;

            case self::STATE_ERROR:
            case self::STATE_FATAL_ERROR:
                $this->onError($json);
                break;

            case self::STATE_REJECTED:
                $this->onRejected($json);
                break;

            default:
                throw new \Exception("Invalid state '{$json["StateName"]}' retrieved from PollUrl.");
        }
    }

    /**
     * Return the URL which we poll for status updates.
     *
     * @return string
     */
    public function getPollUrl()
    {
        return $this->pollUrl;
    }

    /**
     * Return the URL which the data can be retrieved from, once the queued method has completed.
     *
     * @return string
     */
    public function getDataUrl()
    {
        return $this->dataUrl;
    }

    /**
     * Retrieve the data from the DataUrl,
     * throws an exception if the data is not ready.
     *
     * @throws \Exception
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function retrieveData()
    {
        if ($this->isDataReady() === false) {
            throw new \Exception("The data is not ready yet");
        }

        $response = $this->client->request("get", $this->dataUrl);
        return json_decode($response->getBody()->getContents(), true);
    }

    /**
     * @param $response
     */
    protected function onCompleted($response)
    {
        $this->dataUrl = $response["DataUrl"];
        $this->isDataReady = true;
    }

    public function isDataReady()
    {
        return $this->isDataReady;
    }

    /**
     * @param $response
     * @throws \Exception
     */
    protected function onError($response)
    {
        throw new \Exception($response["Message"]);
    }

    /**
     * @param $json
     * @throws \Exception
     */
    private function onRejected($response)
    {
        throw new \Exception("The queued job was rejected because it was in the queue too long.");
    }
}