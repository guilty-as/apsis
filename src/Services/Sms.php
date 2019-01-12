<?php


namespace Guilty\Apsis\Services;


use Guilty\Apsis\Utils\DateFormatter;

class Sms extends Service
{
    /**
     * Create new SMS message on the account. (direct)
     *
     * @param string $name The name of the SMS message visible in the UI (required)
     * @param string $text SMS message content (required)
     * @param null|string|int $folderId The ID of the folder to place the SMS message in (optional)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createSmsMessage($name, $text, $folderId = null)
    {
        $params = array_filter([
            "Name" => $name,
            "Text" => $text,
            "FolderId" => $folderId
        ]);

        $endpoint = "/v1/sms/messages";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }


    /**
     * Retrieve Incoming SMS Messages (direct)
     *
     * @param string|int $numberRespondedTo The Phone Number recipients used to reply with their SMS to (optional)
     * @param \DateTimeInterface $start Start date for the requested period (optional)
     * @param \DateTimeInterface $end End date for the requested period (optional)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getIncomingSmsMessages($numberRespondedTo, \DateTimeInterface $start, \DateTimeInterface $end)
    {
        $query = http_build_url([
            "to-number" => $numberRespondedTo,
            "from" => DateFormatter::safeFormat($start, $this->dateFormat),
            "to" => DateFormatter::safeFormat($end, $this->dateFormat)
        ]);

        $endpoint = "/sms/v2/incoming-sms-messages?" . $query;
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Retrieve number of SMS credits currently left on the account.
     * Inform whether account is configured to accept linked SMS messages. (direct)
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSmsCredits()
    {
        $endpoint = "/sms/v2/credits";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Retrieve all sms messages from the account (except deleted or hidden messages). (direct)
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSmsMessages()
    {
        $endpoint = "/v1/sms/messages";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Retrieve all sms messages from the account (except deleted or hidden messages). (direct)
     *
     * @param string|int $sendQueueId A Send Queue Identifier
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getSmsRecipientsBySendQueueId($sendQueueId)
    {
        $endpoint = "/sms/v2/recipients/{$sendQueueId}";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Send single SMS to one recipient by providing all necessary data in the request.
     * If no sender name is included in request, your default APSIS Pro SMS sender name will be used.
     * Date format yyyyMMddTHHmmss.
     * Also allows for use of linked SMS, that is if more than 160 chars (70 chars when special chars are present)
     * an additional SMS will be sent.
     *
     * Note! "SMS", as well as "Linked SMS" are add-on features of APSIS Pro.
     *
     * Please contact Apsis at info@apsis.com if you would like to use these features. (direct)
     *
     * @param string $message Message send to recipient (required)
     * @param string|int $countryCode The recipient's country code (required)
     * @param string|int $phoneNumber The recipient's phone number (required)
     * @param string $senderName If not specified, your APSIS Pro default SMS sender name will be used. (optional)
     * @param bool $isLinked If more than 160 chars, should the remaining part be ignored (False) or sent in an adjacent SMS (True)?
     * @param \DateTimeInterface|null $sendDate Send date (optional)
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function send($message, $countryCode, $phoneNumber, $senderName = null, $isLinked = false, \DateTimeInterface $sendDate = null)
    {
        $params = array_filter([
            "Message" => $message,
            "CountryCode" => $countryCode,
            "PhoneNumber" => $phoneNumber,
            "SenderName" => $senderName,
            "IsLinked" => $isLinked,
            "SendDate" => DateFormatter::safeFormat($sendDate, $this->dateFormat),
        ]);

        $endpoint = "/sms/v2/";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Send an existing SMS to one or more mailing lists by providing all necessary data in the request.
     * If no sender name is included in request, the mailing list sender name will be used.
     *
     * Also allows for use of linked SMS, that is if more than 160 chars (70 chars when special chars are present)
     * an additional SMS will be sent.
     * Optional to include a CampaignId.
     * This method returns a SendQueueId in response to a successful call.
     *
     * Note! "SMS", as well as "Linked SMS" are add-on features of APSIS Pro.
     * Please contact Apsis at info@apsis.com if you would like to use these features. (direct)
     *
     * @param int $smsMessageId The identifier of the SMS to send (required)
     * @param array|int[] $mailingListIds The list of MailingListId values to send to (required)
     * @param string|null $senderName The sender name (optional). If not provided, the mailing list sender name will be used. 3 to 11 characters (a-z, A-Z and 0-9). Note that not all providers support spaces in the sender name. It can be removed in some cases.
     * @param \DateTimeInterface|null $sendDate The date and time when the SMS will be sent (optional). If not provided, SMS will be sent immediatelly.
     * @param int|null $filterId For sending to a subset of recipients on the mailing list(s) (optional). If not provided, SMS will be sent to all mailing list(s) recipients
     * @param string|null $campaignId Campaign identifier for future use (optional). Max 50 chars allowed.
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function sendSmsMessage($smsMessageId, $mailingListIds, $senderName = null,
                                   \DateTimeInterface $sendDate = null, $filterId = null, $campaignId = null)
    {
        // Validate the campaign id for max char length.
        if (is_string($campaignId) && strlen($campaignId) > 50) {
            throw new \InvalidArgumentException("CampaignId can be max 50 chars long.");
        }

        $params = array_filter([
            "SmsMessageId" => $smsMessageId,
            "MailingListIds" => $mailingListIds,
            "SenderName" => $senderName,
            "SendDate" => DateFormatter::safeFormat($sendDate, $this->dateFormat),
            "FilterId" => $filterId,
            "CampaignId" => $campaignId,
        ]);


        $endpoint = "/v1/sms/send";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);

    }
}
