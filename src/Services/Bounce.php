<?php


namespace Guilty\Apsis\Services;


class Bounce extends Service
{
    /**
     * Get all bounces for an account (Queued)
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAll()
    {
        $endpoint = "/v1/bounces/queued";
        $response = $this->client->request("post", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get All Bounces (Paginated)
     *
     * @param string|int $pageNumber
     * @param string|int $pageSize
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllPaginated($pageNumber, $pageSize)
    {
        $endpoint = "/v1/bounces/page/{$pageNumber}/size/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get bounces for a specific sending (Paginated)
     *
     * @param string|int $sendQueueId
     * @param string|int $pageNumber
     * @param string|int $pageSize
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBouncesForSendingPaginated($sendQueueId, $pageNumber, $pageSize)
    {
        $endpoint = "/v1/bounces/sendqueues/{$sendQueueId}/page/{$pageNumber}/size/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get bounces between two dates (Queued)
     *
     * @param $startDateStr
     * @param $endDateStr
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByDateInterval($startDateStr, $endDateStr)
    {
        // TODO: Accept DateTime objects and convert to correct format,
        // TODO: currently waiting for apsis api support to tell me which format is supposed to be used, it was not in the docs.
        $endpoint = "/v1/bounces/date/from/{$startDateStr}/to/{$endDateStr}";
        $response = $this->client->request("post", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get bounces for an account between two dates (Paginated)
     *
     * @param $startDateStr
     * @param $endDateStr
     * @param string|int $pageNumber
     * @param string|int $pageSize
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByDateIntervalPaginated($startDateStr, $endDateStr, $pageNumber, $pageSize)
    {
        $endpoint = "/v1/bounces/date/from/{$startDateStr}/to/{$endDateStr}/page/{$pageNumber}/size/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get bounce by sendqueueIds (Queued)
     *
     * @param array|int[] $sendqueueIds array of integers
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBySendqueueIds($sendqueueIds)
    {
        $endpoint = "/v1/bounces/sendqueues/queued";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $sendqueueIds
        ]);

        return $this->responseToJson($response);
    }
}