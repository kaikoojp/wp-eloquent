<?php
/**
 * Created by PhpStorm.
 * User: aozora0000
 * Date: 2019-02-21
 * Time: 16:04
 */

namespace WeDevs\ORM\WP;

use WeDevs\ORM\WP\Util\Option as BaseOption;
use WeDevs\ORM\WP\Util\Str;

class Option
{

    /**
     * @param string $key
     * @param mixed  $value
     * @return bool
     */
    public static function set(string $key, $value): bool
    {
        if (!is_scalar($value)) {
            $value = serialize($value);
        }
        $option = BaseOption::updateOrCreate(['option_name' => $key], ['option_value' => $value]);
        return $option->exists;
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function exists(string $key): bool
    {
        return BaseOption::where('option_name', $key)->exists();
    }

    /**
     * @param string $key
     * @return \Illuminate\Database\Eloquent\Model|object|BaseOption|null
     */
    protected static function _get(string $key)
    {
        return BaseOption::where('option_name', $key)->first();
    }

    /**
     * @param string     $key
     * @param null|mixed $default
     * @return mixed
     */
    public function get(string $key, $default = null)
    {
        if ($option = static::_get($key)) {
            $value = $option->getAttribute('option_value');
            switch (true) {
                case Str::isSerializeString($value):
                    return unserialize($value);
                case Str::isJsonString($value):
                    return json_decode($value, true);
                default:
                    return $value;
            }
        }
        return $default;
    }

    /**
     * @param string $key
     * @return bool
     * @throws \Exception
     */
    public static function delete(string $key): bool
    {
        if ($option = static::_get($key)) {
            return $option->delete();
        }
        return false;
    }
}