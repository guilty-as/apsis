<?php


namespace Guilty\Apsis\Services;


class Account extends Service
{
    /**
     * Creates a Single sign-on URL for direct login access to account,
     * e.g. to be used for single sign-on from external environments (direct)
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createSingleSignOnUrl()
    {
        $endpoint = "/v1/accounts/login/url";
        $response = $this->client->request("get", $endpoint);
        return $this->responseToJson($response);
    }

    /**
     * Retrieve demographic data fields for an account.
     * If optional values have been defined for a certain demographic data field, these will also be returned.
     *
     * Will also return true/false for Visible which means if a demographic data field should be visible nor
     * not when subscribers open the "Update My Subscription" page generated when using
     * ##UpdateMySubscription## in an APSIS Pro email. (direct)
     *
     * @return mixed|\Psr\Http\Message\ResponseInterface
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getDemographicData()
    {
        $endpoint = "/accounts/v2/demographics";
        $response = $this->client->request("get", $endpoint);
        return $this->responseToJson($response);
    }
}