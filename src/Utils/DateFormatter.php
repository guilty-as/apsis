<?php


namespace Guilty\Apsis\Utils;


class DateFormatter
{

    /**
     * Provides a safe (won't throw errors if provided
     * an invalid date) way to format a date to a specific format.
     *
     * @param  $date
     * @param string $format Date format
     * @return string|null Formatted date as string or null.
     */
    public static function safeFormat($date, $format)
    {
        return $date instanceof \DateTimeInterface ? $date->format($format) : null;
    }

}