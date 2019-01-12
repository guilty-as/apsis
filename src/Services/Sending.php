<?php


namespace Guilty\Apsis\Services;


use Guilty\Apsis\Utils\DateFormatter;

class Sending extends Service
{

    /**
     * Delete a sending for a given sendQueueId
     *
     * @param string|int $sendQueueId Id of the sendqueue
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteSendingById($sendQueueId)
    {
        $endpoint = "/sendqueues/v2/{$sendQueueId}";
        $response = $this->client->request("delete", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get bounces for a specific sending, optionally by date interval.
     * Also returns the parameter ”ExternalID” which allows you to map results with external data sources.
     *
     * @param string|int $sendQueueId The send queue id
     * @param \DateTimeInterface $dateFrom Start date of date interval
     * @param \DateTimeInterface $dateTo End date of date interval
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBounces($sendQueueId, \DateTimeInterface $dateFrom, \DateTimeInterface $dateTo)
    {
        $query = http_build_query([
            "dateFrom" => DateFormatter::safeFormat($dateFrom, $this->dateFormat),
            "dateTo" => DateFormatter::safeFormat($dateTo, $this->dateFormat)
        ]);

        $endpoint = "/v1/sendqueues/{$sendQueueId}/bounces?" . $query;
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get clicks for a specific sending, optionally by date interval.
     * Also returns the parameter ”ExternalID” which allows you to map results with external data sources.
     *
     * @param string|int $sendQueueId The send queue id
     * @param \DateTimeInterface $dateFrom Start date of date interval
     * @param \DateTimeInterface $dateTo End date of date interval
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getClicks($sendQueueId, \DateTimeInterface $dateFrom, \DateTimeInterface $dateTo)
    {
        $query = http_build_query([
            "dateFrom" => DateFormatter::safeFormat($dateFrom, $this->dateFormat),
            "dateTo" => DateFormatter::safeFormat($dateTo, $this->dateFormat)
        ]);

        $endpoint = "/v1/sendqueues/{$sendQueueId}/clicks?" . $query;
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get all sendings on account scheduled for future send-out (direct).
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getFutureSendings()
    {
        $endpoint = "/v1/sendqueues/future";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get clicks for a specific sending, optionally by date interval.
     * Also returns the parameter ”ExternalID” which allows you to map results with external data sources.
     *
     * @param string|int $sendQueueId The send queue id
     * @param \DateTimeInterface $dateFrom Start date of date interval
     * @param \DateTimeInterface $dateTo End date of date interval
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOpens($sendQueueId, \DateTimeInterface $dateFrom, \DateTimeInterface $dateTo)
    {
        $query = http_build_query([
            "dateFrom" => DateFormatter::safeFormat($dateFrom, $this->dateFormat),
            "dateTo" => DateFormatter::safeFormat($dateTo, $this->dateFormat)
        ]);

        $endpoint = "/v1/sendqueues/{$sendQueueId}/opens?" . $query;
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get optouts for a specific sending, optionally by date interval.
     * Also returns the parameter ”ExternalID” which allows you to map results with external data sources.
     *
     * @param string|int $sendQueueId The send queue id
     * @param \DateTimeInterface $dateFrom Start date of date interval
     * @param \DateTimeInterface $dateTo End date of date interval
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOptOuts($sendQueueId, \DateTimeInterface $dateFrom, \DateTimeInterface $dateTo)
    {
        $query = http_build_query([
            "dateFrom" => DateFormatter::safeFormat($dateFrom, $this->dateFormat),
            "dateTo" => DateFormatter::safeFormat($dateTo, $this->dateFormat)
        ]);

        $endpoint = "/v1/sendqueues/{$sendQueueId}/opens?" . $query;
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Return a paginated list of all the sendings for this account
     *
     * @param string|int $pageNumber The page in the resultset to return, starts with 1
     * @param string|int $pageSize The size of each page resultset, minimum 1
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPaginated($pageNumber, $pageSize)
    {
        $endpoint = "/v1/sendqueues/page/{$pageNumber}/size/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get sending details for a given sendQueueId
     * 2016-01-27 v2: (first version is v2)
     *
     * @param string|int $sendQueueId Id of the send queue
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSendingById($sendQueueId)
    {
        $endpoint = "/sendqueues/v2/{$sendQueueId}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get sendings by interval
     *
     * @param \DateTimeInterface $start Start date
     * @param \DateTimeInterface $end End date
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSendingsByDateInterval(\DateTimeInterface $start, \DateTimeInterface $end)
    {
        $endpoint = "/v1/sendqueues/date/from/{$start->format($this->dateFormat)}/to/{$start->format($this->dateFormat)}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get sendings by newsletter Id
     *
     * @param string|int $newsletterId Id of the newsletter
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSendingsByNewsletterId($newsletterId)
    {
        $endpoint = "/v1/sendqueues/newsletter/{$newsletterId}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Gets a paginated list of all to a specific subscriber
     *
     * @param string|int $subscriberId Subscriber ID
     * @param string|int $pageNumber Page number
     * @param string|int $pageSize Page size
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSendingsBySubscriberId($subscriberId, $pageNumber, $pageSize)
    {
        $endpoint = "/sendqueues/v1/sendings/subscriber/{$subscriberId}/{$pageNumber}/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Send an email campaign or a newsletter to one or more lists.
     * This method can also be used to send SMS to a list.
     * Optional to include a CampaignId. This Id will be available shortly in API methods
     * related to send-outs (i.e. it can currently not be retrieved using the API).
     *
     * This method returns a SendQueueId in response to a successful call.
     *
     * @param array $newsletterDetails The details about the send-out to be performed
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendNewsletter($newsletterDetails)
    {
        $endpoint = "/sendqueues/v2/";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $newsletterDetails
        ]);

        return $this->responseToJson($response);
    }
}
