<?php

namespace Guilty\Apsis\Types;

class OperatorValue
{
    // 1 = 'LIKE' (equals)
    const LIKE = 1;

    // 2 = 'NOT LIKE'
    const NOT_LIKE = 2;

    // 3 = '<>'
    const NOT_EQUAL = 3;

    // 4 = '='
    const EQUAL = 4;

    // 5 = '< alfanumeric (abc123)'
    const ALPHANUMERIC_LESS = 5;

    // 6 = '> alfanumeric(abc123)'
    const ALPHANUMERIC_MORE = 6;

    // 7 = '< numeric(123)'
    const NUMERIC_LESS = 7;

    // 8 = '> numeric(123)'
    const NUMERIC_MORE = 8;

    // 9 = '< date(yyyy-mm-dd)'
    const DATE_BEFORE = 9;

    // 10 = '> date(yyyy-mm-dd)'
    const DATE_AFTER = 10;
}