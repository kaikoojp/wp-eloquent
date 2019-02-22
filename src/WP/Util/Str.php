<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-21
 * Time: 16:29
 */

namespace WeDevs\ORM\WP\Util;

class Str
{
    /**
     * @param mixed $data
     * @return bool
     */
    public static function isSerializeString($data): bool
    {
        return @unserialize($data) !== false;
    }

    public static function isJsonString($data): bool
    {
        return (is_string($data) && is_array(json_decode($data, true)) && (json_last_error() === JSON_ERROR_NONE));
    }
}