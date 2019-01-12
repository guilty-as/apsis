<?php


namespace Guilty\Apsis\Services;


class Click extends Service
{
    /**
     * Get clicks based on SendQueueID, ordered by click ID (Paginated)
     *
     * @param string|int $sendQueueId
     * @param string|int $pageNumber
     * @param string|int $pageSize
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function GetClicksBySendqueueIdPaginated($sendQueueId, $pageNumber, $pageSize)
    {
        $endpoint = "/v1/clicks/sendqueues/{$sendQueueId}/page/{$pageNumber}/size/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }
}