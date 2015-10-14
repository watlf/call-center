<?php
/**
 * Created by PhpStorm.
 * User: andrey.ly
 * Date: 6/29/15
 * Time: 12:06 AM
 */

namespace Application\Helper;


class DateHelper
{
    const DATE_FORMAT = 'F j, Y, g:i a';

    /**
     * @param $date
     * @param string $format
     * @return string
     */
    public static function dateFormat($date, $format = self::DATE_FORMAT)
    {
        $timestamp = strtotime($date);
        if ($timestamp) {
            $date = date($format, $timestamp);
        }

        return $date;
    }

}