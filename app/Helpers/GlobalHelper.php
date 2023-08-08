<?php

use Carbon\Carbon;


function isDateMySqlFormat($date)
{
    return (preg_match("/^[0-9]{4}-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])$/", $date));
}

function sqlToHTMLByDateDetection($sqlDate)
{

    if ($sqlDate === '' || $sqlDate === null || $sqlDate === '0000-00-00') {
        return '';
    }

    if (isDateMySqlFormat($sqlDate)) {
        return (new Carbon($sqlDate))->format('m/d/Y');
    }

    return $sqlDate;
}


//function sqlToHTML

function sqlToHtmlDate($sqlDate)
{
    if ($sqlDate === '' || $sqlDate === null || $sqlDate === '0000-00-00') {
        return '';
    }

    return (new Carbon($sqlDate))->format('m/d/Y');
}

function clean($string)
{

    return preg_replace('/[^A-Za-z0-9\-]/', ' ', $string); // Removes special chars.
}

function humanReadableDateTime($dateTime)
{
    return (new Carbon($dateTime))->format('M d, Y, h:i:s');
}

function dateToClassName($date)
{

    return (new Carbon($date))->format('h-i-s');
}
