<?php


namespace Guilty\Apsis\Builders;


use Guilty\Apsis\Types\SubscriptionImportMode;
use Ramsey\Uuid\Uuid;

class CsvImport
{
    protected $url;
    protected $hasHeader = true;
    protected $delimiterChar = ",";
    protected $quoteChar = "\"";
    protected $escapeChar = "\\";
    protected $commentChar = "#";
    protected $isZipped = false;
    protected $archiveFileName = null;
    protected $operationMode = SubscriptionImportMode::IMPORT;
    protected $callbackId = null;
    protected $demographicDataMapping = [];

    /**
     * CsvImport constructor.
     *
     * @param string $url URL to CSV formatted file with subscriber data
     * @param string $operationMode Which import mode should be used, "Import" or "Sync"
     * @throws \Exception
     */
    public function __construct($url, $operationMode = SubscriptionImportMode::IMPORT)
    {
        $this->url = $url;
        $this->operationMode = $operationMode;
        $this->callbackId = Uuid::uuid4();
    }

    /**
     * @param string $url URL to CSV formatted file with subscriber data
     * @param string $operationMode Which import mode should be used, "Import" or "Sync"
     * @throws \Exception
     */
    public static function build($url, $operationMode = SubscriptionImportMode::IMPORT)
    {
        return new static($url, $operationMode);
    }

    /**
     * Explicitly map CSV file column index to demographic data field index.
     *
     * @param int $filePosition 1-index based
     * @param int $demographicsDataField 1-index based
     */
    public function addDemographicDataMapping($filePosition, $demographicsDataField)
    {
        $this->demographicDataMapping[] = [
            "ImportFilePosition" => $filePosition,
            "DemographicDataField" => $demographicsDataField,
        ];

        return $this;
    }

    /**
     * If CSV file has header (True) or not (False)
     *
     * @param bool $hasHeader
     * @return CsvImport
     */
    public function setHasHeader(bool $hasHeader): CsvImport
    {
        $this->hasHeader = $hasHeader;
        return $this;
    }

    /**
     * Which Delimiter character is used
     *
     * @param string $delimiterChar
     * @return CsvImport
     */
    public function setDelimiterChar(string $delimiterChar): CsvImport
    {
        $this->delimiterChar = $delimiterChar;
        return $this;
    }

    /**
     * Which Quote character is used
     *
     * @param string $quoteChar
     * @return CsvImport
     */
    public function setQuoteChar(string $quoteChar): CsvImport
    {
        $this->quoteChar = $quoteChar;
        return $this;
    }

    /**
     * Which Escape character is used
     *
     * @param string $escapeChar
     * @return CsvImport
     */
    public function setEscapeChar(string $escapeChar): CsvImport
    {
        $this->escapeChar = $escapeChar;
        return $this;
    }

    /**
     * Which Comment character is used
     *
     * @param string $commentChar
     * @return CsvImport
     */
    public function setCommentChar(string $commentChar): CsvImport
    {
        $this->commentChar = $commentChar;
        return $this;
    }

    /**
     * If file is in zip format (True) or not (False)
     *
     * @param bool $isZipped
     * @return CsvImport
     */
    public function setIsZipped(bool $isZipped): CsvImport
    {
        $this->isZipped = $isZipped;
        return $this;
    }

    /**
     * Name of the archived file. Used when file is zipped (Optional)
     *
     * @param string $archiveFileName
     * @return CsvImport
     */
    public function setArchiveFileName($archiveFileName)
    {
        $this->archiveFileName = $archiveFileName;
        return $this;
    }

    public function toArray()
    {
        return [
            "ArchiveFileName" => $this->archiveFileName,
            "CallbackId" => $this->callbackId->toString(),
            "CommentChar" => $this->commentChar,
            "DelimiterChar" => $this->delimiterChar,
            "DemographicDataMapping" => $this->demographicDataMapping,
            "EscapeChar" => $this->escapeChar,
            "HasHeader" => $this->hasHeader,
            "IsZipped" => $this->isZipped,
            "OperationMode" => $this->operationMode,
            "QuoteChar" => $this->quoteChar,
            "Url" => $this->url,
        ];
    }
}