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
     * @param \DateTimeInterface $start
     * @param \DateTimeInterface $end
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getByDateInterval(\DateTimeInterface $start, \DateTimeInterface $end)
    {
        $endpoint = "/v1/bounces/date/from/{$start->format($this->dateFormat)}/to/{$end->format($this->dateFormat)}";
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
    public function getByDateIntervalPaginated(\DateTimeInterface $start, \DateTimeInterface $end, $pageNumber, $pageSize)
    {
        $endpoint = "/v1/bounces/date/from/{$start->format($this->dateFormat)}/to/{$end->format($this->dateFormat)}/page/{$pageNumber}/size/{$pageSize}";
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