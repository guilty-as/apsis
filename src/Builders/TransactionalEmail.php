<?php


namespace Guilty\Apsis\Builders;


class TransactionalEmail
{
    const SENDING_TYPE_MARKETING = "m";
    const SENDING_TYPE_TRANSACTIONAL = "t";

    protected $email;
    protected $name;
    protected $format;
    protected $externalId;
    protected $countryCode;
    protected $phoneNumber;
    protected $demDataFields = [];
    protected $dDHtml;
    protected $sendingType;
    protected $attachments = [];


    public function __construct($email, $sendingType)
    {
        $this->email = $email;
        $this->sendingType = $sendingType;
    }

    public static function build($email, $sendingType = self::SENDING_TYPE_TRANSACTIONAL)
    {
        return new static($email, $sendingType);
    }

    /**
     * @param mixed $name
     * @return $this
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Supported: HTML or text.
     * I assume, docs doesnt specify the supported formats, but shows an example
     * with "HTML", so i assume it works as most email sending services do,
     * supporting html and plain text.. Good luck i guess.
     *
     * @param mixed $format
     * @return $this
     */
    public function setFormat($format)
    {
        $this->format = $format;
        return $this;
    }

    /**
     * @param mixed $externalId
     * @return $this
     */
    public function setExternalId($externalId)
    {
        $this->externalId = $externalId;
        return $this;
    }

    /**
     * @param mixed $countryCode
     * @return $this
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @param mixed $phoneNumber
     * @return $this
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
        return $this;
    }

    /**
     * @param mixed $demDataFields
     * @return $this
     */
    public function setDemDataFields($demDataFields)
    {
        $this->demDataFields = $demDataFields;
        return $this;
    }

    /**
     * @param mixed $dDHtml
     * @return $this
     */
    public function setDDHtml($dDHtml)
    {
        $this->dDHtml = $dDHtml;
        return $this;
    }

    /**
     * @param mixed $sendingType
     * @return $this
     */
    public function setSendingType($sendingType)
    {
        $this->sendingType = $sendingType;
        return $this;
    }


    /**
     * @param string $filePath path to file to attach
     * @param string $name name of file
     * @param string|null $contentType the content type (mime type) of the file, ex: application/xml, application/pdf
     * @return $this
     */
    public function addAttachment($filePath, $name, $contentType = null)
    {
        if (file_exists($filePath) === false) {
            throw new \InvalidArgumentException("File provided in filepath does not exist");
        }

        $this->attachments[] = [
            "Content" => file_get_contents($filePath),
            "ContentType" => $contentType ?? mime_content_type($filePath), // TODO: Check if this works properly
            "Name" => $name,
        ];

        // TODO(12 jan 2019) ~ Helge: Add a check to see if the total size of attachments exceed 1 MB

        return $this;
    }


    /**
     * @param $key
     * @param $value
     * @return $this
     */
    public function addDemDataField($key, $value)
    {
        $this->demDataFields[] = [
            "key" => $key,
            "value" => $value
        ];

        return $this;
    }

    public function toArray()
    {
        return array_filter([
            "Email" => $this->email,
            "Name" => $this->name,
            "Format" => $this->format,
            "ExternalId" => $this->externalId,
            "CountryCode" => $this->countryCode,
            "PhoneNumber" => $this->phoneNumber,
            "DemDataFields" => $this->demDataFields,
            "DDHtml" => $this->dDHtml,
            "SendingType" => $this->sendingType,
            "Attachments" => $this->attachments,
        ]);
    }
}