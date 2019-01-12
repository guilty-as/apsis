<?php


namespace Guilty\Apsis\Services;


class OptOut extends Service
{
    /**
     * Deletes a subscriber from the Opt-out all list in APSIS Pro.
     * NB! The subscriber will be deleted from the account in this process (direct).
     *
     * @param string $subscriberEmail Subscriber e-mail
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteSubscriberFromOptOutAllByEmail($subscriberEmail)
    {
        $endpoint = "/v1/optouts/global/subscriber/email";
        $response = $this->client->request("delete", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $subscriberEmail
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Deletes subscribers from the Opt out all list in APSIS Pro.
     * NB! The subscribers will be deleted from the account in this process.
     *
     * @param int[] $subscriberIds Subscriber ids to delete
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteSubscribersFromOptOutAll($subscriberIds)
    {
        $endpoint = "/v1/optouts/global/subscribers/queued";
        $response = $this->client->request("delete", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $subscriberIds
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Deletes subscribers from the Opt out all list by emails in APSIS Pro.
     * NB! The subscribers will be deleted from the account in this process.
     * Max number of email addresses in body request is 1000. (Queued)
     *
     * @param string[] $subscriberEmails Subscriber emails to delete
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteSubscribersFromOptOutAllByEmail($subscriberEmails)
    {
        if (count($subscriberEmails) > 1000) {
            throw new \InvalidArgumentException("Max number of email addresses per request is 1000");
        }

        $endpoint = "/optouts/v1/global/subscribers/emails/queued";
        $response = $this->client->request("delete", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $subscriberEmails
        ]);

        return $this->responseToJson($response);
    }

    /**
     * @param string|int $mailinglistId Mailing list ID
     * @param string[] $subscriberEmails Subscriber emails
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteSubscribersFromOptOutListByEmail($mailinglistId, $subscriberEmails)
    {
        if (count($subscriberEmails) > 1000) {
            throw new \InvalidArgumentException("Max number of email addresses per request is 1000");
        }

        $endpoint = "/v1/optouts/mailinglists/{$mailinglistId}/subscribers/queued";
        $response = $this->client->request("delete", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $subscriberEmails
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Gets global opt out list (Queued)
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOptOutAll()
    {
        $endpoint = "/v1/optouts/global/queued";
        $response = $this->client->request("post", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get subscribers on the global opt-out list by date range (date when the subscriber was moved to the global opt-out list) (Queued).
     *
     * @param \DateTimeInterface $start The start date
     * @param \DateTimeInterface $end The end date
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOptOutAllByDateInterval(\DateTimeInterface $start, \DateTimeInterface $end)
    {
        $endpoint = "/optouts/v2/global/queued/{$start->format($this->dateFormat)}/{$end->format($this->dateFormat)}";
        $response = $this->client->request("post", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get global optout list for an account between dates. (Paginated)
     *
     * @param \DateTimeInterface $start The start date
     * @param \DateTimeInterface $end The end date
     * @param string|int $pageNumber The page in the resultset to return, starts with 1
     * @param string|int $pageSize The size of each page resultset, minimum 1
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOptOutAllByDateIntervalPaginated(\DateTimeInterface $start, \DateTimeInterface $end, $pageNumber, $pageSize)
    {
        $endpoint = "/optouts/v2/global/queued/{$start->format($this->dateFormat)}/{$end->format($this->dateFormat)}/{$pageNumber}/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get global opt-out list for an account. (Paginated)
     *
     * @param string|int $pageNumber The page in the resultset to return, starts with 1
     * @param string|int $pageSize The size of each page resultset, minimum 1
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOptOutAllPaginated($pageNumber, $pageSize)
    {
        $endpoint = "/v1/optouts/global/{$pageNumber}/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get subscribers who are on the opt out-list for a list
     *
     * @param string|int $mailinglistId The mailinglist id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOptOutList($mailinglistId)
    {
        $endpoint = "/v1/optouts/mailinglists/{$mailinglistId}/queued";
        $response = $this->client->request("post", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get global opt-out list for a given Mailinglist. (Paginated)
     *
     * @param string|int $mailinglistId The mailinglist id
     * @param string|int $pageNumber The page in the resultset to return, starts with 1
     * @param string|int $pageSize The size of each page resultset, minimum 1
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOptOutListByMailingListPaginated($mailinglistId, $pageNumber, $pageSize)
    {
        $endpoint = "/v1/optouts/{$mailinglistId}/{$pageNumber}/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get a opt out list for a sending
     *
     * @param string|int $sendQueueId The sendQueueId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOptOutListBySendqueueId($sendQueueId)
    {
        $endpoint = "/v1/optouts/sendqueuess/{$sendQueueId}/queued";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get global opt-out list for a given sending (SendQueueID item). (Paginated)
     *
     * @param string|int $sendQueueId The sendQueueId
     * @param string|int $pageNumber The page in the resultset to return, starts with 1
     * @param string|int $pageSize The size of each page resultset, minimum 1
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOptOutListBySendqueueIdPaginated($sendQueueId, $pageNumber, $pageSize)
    {
        $endpoint = "/v1/optouts/sendqueues/{$sendQueueId}/{$pageNumber}/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Moves a batch of subscribers to optout-list
     *
     * @param string|int $mailinglistId Mailing list id
     * @param array $optOutListSubscriberItems Opt out all subscribers items
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function moveSubscribersToOptOutList($mailinglistId, $optOutListSubscriberItems)
    {
        $endpoint = "/v1/optouts/mailinglists/{$mailinglistId}/subscribers/queued";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $optOutListSubscriberItems
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Moves subscribers to optoutall list (Queued)
     *
     * @param array $optOutListSubscriberItems Opt out all subscribers items
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function optOutAllSubscribers($optOutListSubscriberItems)
    {
        $endpoint = "/optouts/v3/global/subscribers/queued";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $optOutListSubscriberItems
        ]);

        return $this->responseToJson($response);
    }
}