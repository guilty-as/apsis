<?php


namespace Guilty\Apsis\Services;


class Open extends Service
{
    /**
     * Get opens based on SendQueueID, ordered by Open ID (Paginated)
     *
     * @param string|int $sendQueueId
     * @param string|int $pageNumber
     * @param string|int $pageSize
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOpensBySendqueueIdPaginated($sendQueueId, $pageNumber, $pageSize)
    {
        $endpoint = "/v1/opens/sendqueues/{$sendQueueId}/page/{$pageNumber}/size/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }
}