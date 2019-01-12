<?php


namespace Guilty\Apsis\Services;


class MailingList extends Service
{
    /**
     * Create a new mailinglist.
     *
     * @param array $mailingListDetails
     * @return mixed
     * @see http://se.apidoc.anpdm.com/Browse/Method/MailingListService/CreateMailinglist
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createMailinglist($mailingListDetails)
    {
        $params = array_merge([
            "CharacterSet" => "utf-8",
            "FolderID" => 0,
        ], $mailingListDetails);

        $endpoint = "/v1/mailinglists/";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Create a subscription for a given MailingList and Subscriber
     *
     * @param string|int $mailinglistId The mailinglist id to which subscriptions should be created
     * @param string|int $subscriberId The ID of the subscriber
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createSingleSubscription($mailinglistId, $subscriberId)
    {
        $endpoint = "/v1/mailinglists/{$mailinglistId}/subscriptions/{$subscriberId}";
        $response = $this->client->request("post", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Create a batch of subscriptions (max. 1000) for a given mailing list and a list of recipients (Queued)
     * 2016-04-25 v2: Reject with validation error if duplicate recipient IDs are found
     *
     * @param string|int $mailinglistId ID of the mailing list to which the subscriptions should be created
     * @param string[]|int[] $recipientIds Unique IDs of the recipients that should be subscribed to that mailing list
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createSubscriptions($mailinglistId, $recipientIds)
    {
        if (count($recipientIds) > 1000) {
            throw new \InvalidArgumentException("Max 1000 subscriptions can be created at once for a given mailing list");
        }

        $endpoint = "/mailinglists/v2/{$mailinglistId}/subscriptions/queued";
        $response = $this->client->request("post", $endpoint, [

        ]);

        return $this->responseToJson($response);
    }

    /**
     * Remove All Subscriptions for a given mailinglist. (Queued)
     *
     * @param string|int $mailinglistId The mailinglist id from which alla subscribers should be deleted.
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteAllMailinglistSubscriptions($mailinglistId)
    {
        $endpoint = "/mailinglists/v2/{$mailinglistId}/subscriptions/all";
        $response = $this->client->request("delete", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Remove all the subscriptions for a given subscriber. (Queued)
     *
     * @param string|int $subscriberId The Id to delete subscriptions from
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteAllSubscriptionsForSubscriber($subscriberId)
    {
        $endpoint = "/v1/mailinglists/subscriptions/{$subscriberId}";
        $response = $this->client->request("delete", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Delete a batch of Mailinglists, with list in body. (max 1000 per request) (Queued)
     *
     * @param string[]|int[] $mailinglistIds The Mailinglists to delete
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteMultipleMailingLists($mailinglistIds)
    {
        if (count($mailinglistIds) > 1000) {
            throw new \InvalidArgumentException("Max 1000 mailinglists can be deleted per request.");
        }

        $endpoint = "/v1/mailinglists/";
        $response = $this->client->request("delete", $endpoint);

        return $this->responseToJson($response);
    }


    /**
     * Remove a subscriber from a given mailinglist.
     *
     * @param string|int $mailinglistId The Mailinglist id
     * @param string|int $subscriberId The Subscriber id
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteSingleSubscription($mailinglistId, $subscriberId)
    {
        $endpoint = "/v1/mailinglists/{$mailinglistId}/subscriptions/{$subscriberId}";
        $response = $this->client->request("delete", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Create a request to get all mailinglists in the system for this account.
     * 2016-01-08 v2: Return response directly, not queued method anymore.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllMailingLists()
    {
        $endpoint = "/mailinglists/v2/all";
        $response = $this->client->request("post", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Return a given Mailinglist and its details
     *
     * @param string|int $mailinglistId The Mailinglist Id to retrieve.
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMailingListDetails($mailinglistId)
    {
        $endpoint = "/v1/mailinglists/{$mailinglistId}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Return a paginated list of all the Mailinglists for this account
     *
     * @param string|int $pageNumber The page in the resultset to return, starts with 1
     * @param string|int $pageSize The size of each page resultset, minimum 1
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMailinglistsPaginated($pageNumber, $pageSize)
    {
        $endpoint = "/v1/mailinglists/{$pageNumber}/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Generate a report of all the subscribers for a given mailinglistID. (Queued)
     * With custom choice of demdata-fields. Notice, if the demographic fields are set as hidden
     * inside the account through the Apsis Pro User Interface, the API won't send those demographic
     * fields and the data in with each subscriber set of data.
     *
     * @param string|int $mailinglistId The Mailinglist Id
     * @param bool $allDemographics True if we should return all the demographic data fields
     * @param array $fieldNames List of fieldnames if we only want to retrieve a limited set of demographic data fields
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMailinglistSubscribers($mailinglistId, $allDemographics = false, $fieldNames = [])
    {
        $params = array_filter([
            "AllDemographics" => $allDemographics,
            "FieldNames" => $fieldNames,
        ]);

        $endpoint = "/mailinglists/v2/{$mailinglistId}/subscribers/all";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Return a paginated list of all the subscribers for this Mailinglist
     *
     * @param string|int $mailingListId The MailinglistID
     * @param string|int $pageNumber The page in the resultset to return, starts with 1
     * @param string|int $pageSize The size of each page resultset, minimum 1
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMailinglistSubscribersPaginated($mailingListId, $pageNumber, $pageSize)
    {
        $endpoint = "/v1/mailinglists/{$mailingListId}/subscribers/{$pageNumber}/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get all subscribers on a mailing list that match a filter, with option to retrieve all, some or no demographic data fields (Queued)
     *
     * @param string|int $mailinglistId The MailinglistID
     * @param string|int $filterId Filter the result on this column
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMailinglistSubscribersWithFilter($mailinglistId, $filterId, $allDemographics = false, $fieldNames = [])
    {
        $params = array_filter([
            "AllDemographics" => $allDemographics,
            "FieldNames" => $fieldNames,
        ]);

        $endpoint = "/v1/mailinglists/{$mailinglistId}/subscribers/all/{$filterId}";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Returns the number of subscribers for a given Mailinglist
     *
     * @param string|int $mailinglistId The Mailinglist Id to retrieve.
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getMailinglistSubscriptionCount($mailinglistId)
    {
        $endpoint = "/v1/mailinglists/{$mailinglistId}/subscriptions/count";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Update an existing mailinglist
     *
     * @param string|int $mailinglistId The Mailinglist identifier
     * @param array $mailingListDetails new mailing list details
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateMailingList($mailinglistId, $mailingListDetails)
    {
        $params = array_filter(array_merge([
            "CharacterSet" => "utf-8",
            "FolderID" => 0,
        ], $mailingListDetails));

        $endpoint = "/v1/mailinglists/{$mailinglistId}";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }

}