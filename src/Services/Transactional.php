<?php


namespace Guilty\Apsis\Services;


use Guilty\Apsis\Builders\TransactionalEmail;
use Guilty\Apsis\Utils\BooleanFormatter;
use Guilty\Apsis\Utils\DateFormatter;

class Transactional extends Service
{
    /**
     * Get bounces for a specific Transactional project, optionally by date interval.
     * Also returns the parameter "ExternalID" which allows you to map results with external data sources.
     *
     * @param string|int $projectId Id of the project
     * @param \DateTimeInterface $dateFrom Start date (optional)
     * @param \DateTimeInterface $dateTo End date (optional)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTransactionalBounces($projectId, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null)
    {
        $query = http_build_query([
            "dateFrom" => DateFormatter::safeFormat($dateFrom, $this->dateFormat),
            "dateTo" => DateFormatter::safeFormat($dateTo, $this->dateFormat)
        ]);

        $endpoint = "/v1/transactional/projects/{$projectId}/bounces?" . $query;
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get clicks for a specific Transactional project, optionally by date interval.
     * Also returns the parameter ”ExternalID” which allows you to map results with external data sources.
     *
     * @param string|int $projectId Id of the project
     * @param \DateTimeInterface $dateFrom Start date (optional)
     * @param \DateTimeInterface $dateTo End date (optional)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTransactionalClicks($projectId, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null)
    {
        $query = http_build_query([
            "dateFrom" => DateFormatter::safeFormat($dateFrom, $this->dateFormat),
            "dateTo" => DateFormatter::safeFormat($dateTo, $this->dateFormat)
        ]);

        $endpoint = "/v1/transactional/projects/{$projectId}/clicks?" . $query;
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get opens for a specific Transactional project, optionally by date interval.
     * Also returns the parameter ”ExternalID” which allows you to map results with external data sources.
     *
     * @param string|int $projectId Id of the project
     * @param \DateTimeInterface $dateFrom Start date (optional)
     * @param \DateTimeInterface $dateTo End date (optional)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTransactionalOpens($projectId, \DateTimeInterface $dateFrom = null, \DateTimeInterface $dateTo = null)
    {
        $query = http_build_query([
            "dateFrom" => DateFormatter::safeFormat($dateFrom, $this->dateFormat),
            "dateTo" => DateFormatter::safeFormat($dateTo, $this->dateFormat)
        ]);

        $endpoint = "/v1/transactional/projects/{$projectId}/opens?" . $query;
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Returns all Transactional projects on an account.
     * Includes information about the NewsletterID, E-mail subject, Created date etc.
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTransactionalProjects()
    {
        $endpoint = "/v1/transactional/projects";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get results from a Transactional Email send-out (the TransactionID is returned in
     * response when SendTransactionalEmail has been called successfully).
     *
     * Also returns demographic data fields and the HTML field (optional), and the
     * parameter ”ExternalID” which allows you to map results with external data sources.
     *
     * @param string|int $transactionId Id of the transaction
     * @param bool $includeDemographicData True/False value indicating if demographic data and ddhtml should be returned or not
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getTransactionResult($transactionId, $includeDemographicData)
    {
        $includeDemographicData = BooleanFormatter::toString($includeDemographicData);

        $endpoint = "/v1/transactional/{$transactionId}/result?includeDemographicData={$includeDemographicData}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Sends a Transactional e-mail to one e-mail address.
     *
     * Allows for use of ExternalID as an input since Transactional results methods also
     * returns this ID in addition to information about opens, clicks etc.
     *
     * Total max size of included attachments 1 MB.
     *
     * @param string|int $projectId Id of the project
     * @param TransactionalEmail $transactionalEmail the email to send, build it with TransactionalEmail::build()
     * @param \DateTimeInterface|null $sendDate Send date (optional)
     * @param bool $allowInactiveProjects True(default)/False value indicating if sending should be allowed when project is inactive (optional)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendTransactionalEmail(
        $projectId,
        TransactionalEmail $transactionalEmail,
        \DateTimeInterface $sendDate = null,
        $allowInactiveProjects = true
    )
    {
        $query = http_build_query([
            "sendDate" => DateFormatter::safeFormat($sendDate, $this->dateFormat),
            "allowInactiveProjects" => $allowInactiveProjects ? "true" : "false"
        ]);

        $endpoint = "/v1/transactional/projects/{$projectId}/sendEmail?" . $query;
        // TODO(12 jan 2019) ~ Helge: Verify that this works right.
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $transactionalEmail->toArray()
        ]);

        return $this->responseToJson($response);
    }

}