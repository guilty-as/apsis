<?php


namespace Guilty\Apsis\Services;


class Filter extends Service
{

    /**
     * Create a new filter by demographic data, for example when filtering subscribers based on their "DemDataFields" list.
     *
     * Examples:
     * - $this->createFilterByDemographicData("Only sweden", "Country", OperatorValue::EQUAL, "Norway")
     * - $this->createFilterByDemographicData("Except sweden", "Country", OperatorValue::NOT_EQUAL, "Sweden")
     *
     * @param string $filterName Filter name. Must not be empty and must be unique. Max length 255 characters.
     * @param string $demographicDataName The name of the demographic data field. Must exist on account and must not be empty. Max length 100 characters.
     * @param string $demographicDataValue The value for the demographic data field. Must not be empty. Max length 500 characters.
     * @param int $operatorValue Supported operators. Value as integer with the following meaning: \
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createFilterByDemographicData($filterName, $demographicDataName, $operatorValue, $demographicDataValue)
    {
        $params = [
            "FilterName" => $filterName,
            "DemographicDataName" => $demographicDataName,
            "DemographicDataValue" => $demographicDataValue,
            "OperatorValue" => $operatorValue,
        ];

        $endpoint = "/filter/v2/CreateFilterByDemographicData";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Get a list of all the filters (queued).
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllFilters()
    {
        $endpoint = "/v1/filter/all";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }
}