<?php


namespace Guilty\Apsis\Services;


use Guilty\Apsis\Utils\BooleanFormatter;

class Subscriber extends Service
{
    /**
     * Create a subscriber on account and add subscription to a list.
     * If the email address already exists on the account, only a subscription to the list will be created
     * (and if UpdateIfExisting is "true", the subscriber data will be updated).
     *
     * NB! In case of bulk imports/updates - you should use one of the methods in the Import service. (Direct)
     *
     *
     * @param string|int $mailingListId
     * @param bool $updateIfExists
     * @param array $subscriber
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createSubscriber($mailingListId, $updateIfExists, $subscriber)
    {
        $updateIfExists = BooleanFormatter::toString($updateIfExists);
        $endpoint = "/v1/subscribers/mailinglist/{$mailingListId}/create?updateIfExists={$updateIfExists}";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $subscriber
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Create 1 to 10 subscribers on account and add to a list. (Queued)
     *
     * @param string|int $mailinglistId
     * @param array $subscribers
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createSubscribers($mailinglistId, $subscribers)
    {
        $endpoint = "/subscribers/v2/mailinglist/{$mailinglistId}/queue";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $subscribers
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Create a subscriber and add a subscription to a specific mailing list in a double opt-in mode.
     * Subscriber is created as pending and an email is sent to them with a link they can use to confirm their subscription.
     * When they click that link, the pending flag is removed and any confirmation email and/or SMS is
     * sent to them based on recipient settings and mailing list settings.
     *
     * If this method is called for a specific email before the subscriber confirms their subscription,
     * another email with the confirmation link is sent.
     *
     * However if it's called after the subscriber confirms their subscription, no email is sent and the subscriber data is updated.
     * If a given email is on opt-out list/all subscriber and subscription will not be created and confirmation link will not be sent.
     *
     * @param $mailinglistId
     * @param $subscriber
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createSubscriberWithDoubleOptIn($mailinglistId, $subscriber)
    {
        $endpoint = "/v1/subscribers/mailinglist/{$mailinglistId}/createWithDoubleOptIn";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $subscriber
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Delete a batch of Subscribers by email adresses. (Queued)
     *
     * @param array $subscriberEmails list of emails (array of strings)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteMultipleSubscribersByEmail($subscriberEmails)
    {
        $endpoint = "/subscribers/v2/email";
        $response = $this->client->request("delete", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $subscriberEmails
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Delete a batch of Subscribers by SubscriberID. (Queued)
     *
     * @param array $subscriberIds list of ids (array of subscriber ids)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteMultipleSubscribersById($subscriberIds)
    {
        $endpoint = "/subscribers/v2/id";
        $response = $this->client->request("delete", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $subscriberIds
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Get all Subscribers in this account (Queued)
     *
     * @param array $subscriberIds list of ids (array of subscriber ids)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllSubscribers($allDemographics = true, $fieldNames = [])
    {
        $params = array_filter([
                "AllDemographics" => $allDemographics,
                "FieldNames" => $fieldNames
            ]
        );

        $endpoint = "/v1/subscribers/all";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Get all Subscribers in this account with filterID (Queued)
     *
     * @param string|int $filterId
     * @param bool $allDemographics
     * @param array $fieldNames
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllSubscribersWithFilter($filterId, $allDemographics = true, $fieldNames = [])
    {
        $params = array_filter([
                "AllDemographics" => $allDemographics,
                "FieldNames" => $fieldNames
            ]
        );

        $endpoint = "/v1/subscribers/all/{$filterId}";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Get all Subscribers in this account without a subscription (Queued)
     *
     * @param bool $allDemographics
     * @param array $fieldNames
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllSubscribersWithoutSubscription($allDemographics = true, $fieldNames = [])
    {
        $params = array_filter([
                "AllDemographics" => $allDemographics,
                "FieldNames" => $fieldNames
            ]
        );

        $endpoint = "/v1/subscribers/orphans";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Gets all recipients for a specific send-out. Includes RecipientId, Email and ExternalId. (Queued)
     *
     * @param string|int $sendQueueId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getRecipientsBySendQueueId($sendQueueId)
    {
        $endpoint = "/subscribers/v2/sendqueueid/{$sendQueueId}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Return a single Subscriber by SubscriberId
     *
     * @param string|int $subscriberId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubscriberDetailsById($subscriberId)
    {
        $endpoint = "/v1/subscribers/id/{$subscriberId}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Gets a list of subscriberIds with a given email
     * 2017-10-25 v3: Returns a list of subscriberIds instead of a singel subscriberId.
     *
     * @param string $email
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubscriberIdByEmail($email)
    {
        $endpoint = "/subscribers/v3/email";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $email
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Get a subscribers active mailinglists by subscriber id
     *
     * @param string $email
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubscriberMailinglists($subscriberId)
    {
        $endpoint = "/v1/subscribers/{$subscriberId}/mailinglists";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Gets a list of subscribers by ExternalId
     *
     * @param string|int $externalId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubscribersByExternalId($externalId)
    {
        $endpoint = "/subscribers/v1/externalId";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $externalId
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Gets a list of subscribers by ExternalId
     *
     * @param string|int $pageNumber
     * @param string|int $pageSize
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSubscribersPaginated($pageNumber, $pageSize)
    {
        $endpoint = "/v1/subscribers/{$pageNumber}/{$pageSize}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Updates 1 to 100 subscribers based on APSIS Pro's SubscriberId.
     * Also allows for update of e-mail address.
     * To delete contents of a field, include the field’s parameter in the request and leave value empty.
     * To keep existing data in a field, don’t include the field’s parameter in the request. (Queued)
     *
     * @param array $subscribers
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateSubscribers($subscribers)
    {
        $endpoint = "/v1/subscribers/queue";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $subscribers
        ]);

        return $this->responseToJson($response);
    }
}