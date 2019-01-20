<?php


namespace Guilty\Apsis\Utils;


class BooleanFormatter
{
    public static function toString($bool)
    {
        return $bool ? "true" : "false";
    }
}