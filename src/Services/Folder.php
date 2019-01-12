<?php


namespace Guilty\Apsis\Services;


class Folder extends Service
{
    /**
     * Create folder (of type Content, Reports, Recipients or PreviewSpamTest)
     *
     * @param $folderName
     * @param $folderType
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createFolder($folderName, $folderType)
    {
        $endpoint = "/v1/folder/";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => [
                "Name" => $folderName,
                "Type" => $folderType,
            ]
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Get all folders available on your account (of types Content, Reports, Recipients or PreviewSpamTest).
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAllFolders()
    {
        $endpoint = "/v1/folder/all";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }
}