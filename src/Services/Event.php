<?php


namespace Guilty\Apsis\Services;


use GuzzleHttp\RequestOptions;

class Event extends Service
{
    /**
     * Adds an attendee and their guests (if any) to a specified event session.
     * Event ID and session ID are always required.
     *
     * Remaining data is matched and validated according to the rules specified by the result of GetControls API method.
     *
     * Works with Event 3.0 or newer (Direct method)
     *
     * @param string|int $eventId
     * @param string|int $sessionId
     * @param array $attendeeData
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function addAttendee($eventId, $sessionId, $attendeeData)
    {
        $endpoint = "/event/v2/{$eventId}/session/{$sessionId}/attendee";
        $response = $this->client->request("get", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $attendeeData
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Gets attendees for event, response can be filtered by event, session and attendee status.
     *
     * @param string|int $eventId The event ID (Required)
     * @param string|int|null $sessionId The event session ID (Optional)
     * @param string|null $attendeeStatus Attendee status (Optional). Allowed values: Registered, WaitingList, CheckedIn, Cancel.
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getAttendees($eventId, $sessionId = null, $attendeeStatus = null)
    {
        $params = array_filter([
            "EventId" => $eventId,
            "EventSessionId" => $sessionId,
            "AttendeeStatus" => $attendeeStatus
        ]);

        $endpoint = "/event/v2/attendees";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Gets event registration form controls as configured in event registration form editor.
     *
     * @param string|int $eventId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getControls($eventId)
    {
        $endpoint = "/event/v2/{$eventId}/registrationForm/controls";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Get status for all participants of an event.
     * Returns the EventId, EventName, RecipientId, EmailAddress, ExternalId, EventParticipantStatus
     * (which can be Registered, WaitingList, CheckedIn, Decline, Cancel, NotRegistered),
     * RgistrationDate, StatusUpdatedDate, EventSessionId, EventSessionName and Guests.
     *
     * Guests refer to the number of anonymous guests an event participant has added.
     *
     * Works only with Event 2.0 which is now DEPRECATED (Queued method)
     *
     * @param string|int $eventId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventParticipantStatus($eventId)
    {
        $endpoint = "/event/v1/statuses/{$eventId}/queued";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);

    }

    /**
     * Get a list of all events on the account.
     * Includes the EventId, EventName, EventTitle, CreatedDate and UpdatedDate.
     * Disabled (true/false) indicates if the event is enabled or not.
     *
     * Works only with Event 2.0 which is now DEPRECATED (Direct method)
     *
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEvents()
    {
        $endpoint = "/event/v1/all";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Gets attendee for event session.
     * If "Allow registration of additional guests" and "Request guest details in form"
     * are both enabled then non-anonymous attendee guests are included in the response.
     *
     * Works with Event 3.0 or newer (Direct method)
     *
     * @param $eventId
     * @param $sessionId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventSessionAttendee($eventId, $sessionId, $attendeeEmail)
    {
        $endpoint = "/event/v2/{$eventId}/session/{$sessionId}/attendee/email/";
        $response = $this->client->request("post", $endpoint, [
            RequestOptions::JSON => $attendeeEmail
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Gets all events with their sessions.
     * Includes: events registration settings, session registration settings and session parameters.
     *
     * Works with Event 3.0 or newer (Direct method)
     *
     * Optional Filters:
     * - StartTime (String): The event start date (Optional)
     * - EndTime (String): The event end date (Optional)
     * - ExcludeEnabled (Boolean):  Exclude enabled events (Optional)
     * - ExcludeDisabled (Boolean):  Exclude disabled events (Optional)
     *
     * @param $filters
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventsWithSessions($filters = null)
    {
        $params = array_filter(array_merge([
            "StartTime" => null,
            "EndTime" => null,
            "ExcludeEnabled" => null,
            "ExcludeDisabled" => null,
        ], $filters));

        $endpoint = "/event/v2/sessions";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $params
        ]);

        return $this->responseToJson($response);
    }


    /**
     * Gets a specific event with its sessions.
     * Includes: event registration settings, session registration settings and session parameters.
     *
     * Works with Event 3.0 or newer (Direct method)
     *
     * @param string|int $eventId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getEventWithSessions($eventId)
    {
        $endpoint = "/event/v2/{$eventId}/sessions";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Gets options data categories for given event.
     *
     * Works with Event 3.0 or newer (Direct method)
     *
     * @param string|int $eventId
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getOptionsDataCategories($eventId)
    {
        $endpoint = "/event/v2/{$eventId}/optionsdatacategories";
        $response = $this->client->request("get", $endpoint);

        return $this->responseToJson($response);
    }

    /**
     * Registers an attendee and their guests (if any) to a specified event session.
     * Event ID and session ID are always required.
     * Remaining data is matched and validated according to the rules specified by the result of GetControls API method.
     *
     * Works with Event 3.0 or newer (Direct method)
     *
     * @param string|int $eventId
     * @param string|int $sessionId
     * @param array $attendeeData
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function registerAttendee($eventId, $sessionId, $attendeeData)
    {
        $endpoint = "/event/v2/{$eventId}/session/{$sessionId}/register";
        $response = $this->client->request("post", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $attendeeData
        ]);

        return $this->responseToJson($response);
    }

    /**
     * Updates attendee to a specified event session.
     * Event id, session id and attendee id are required.
     * Remaining data is matched and validated according to the rules specified by the result
     * of GetControls API method Works with Event 3.0 or newer (Direct method)
     *
     * @param string|int $eventId
     * @param string|int $sessionId
     * @param string|int $attendeeId
     * @param array $attendeeData
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateAttendee($eventId, $sessionId, $attendeeId, $attendeeData)
    {
        $endpoint = "/event/v2/{$eventId}/session/{$sessionId}/attendee/{$attendeeId}";
        $response = $this->client->request("put", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $attendeeData
        ]);

        return $this->responseToJson($response);
    }


    /**
     * Updates attendee status.
     * Works with Event 3.0 or newer (Direct method)
     *
     * @param string|int $eventId
     * @param string|int $attendeeId
     * @param string $attendeeStatus
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function updateAttendeeStatus($eventId, $attendeeId, $attendeeStatus)
    {
        // TODO(12 jan 2019) ~ Helge: Put valid attendeeStatuses into its own "enum"

        $endpoint = "/event/v2/{$eventId}/attendee/{$attendeeId}/status";
        $response = $this->client->request("put", $endpoint, [
            \GuzzleHttp\RequestOptions::JSON => $attendeeStatus
        ]);

        return $this->responseToJson($response);
    }

}
