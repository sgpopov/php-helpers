<?php

namespace Helpers;

class Arr
{
    /**
     * Trims each array element.
     *
     * @param array $arr
     * @param string $charlist
     *
     * @return array
     */
    public static function trim($arr, $charlist = " \t\n\r\0\x0B") : array
    {
        if (is_string($arr)) {
            return trim($arr, $charlist);
        }

        if (is_array($arr)) {
            foreach ($arr as $key => $value) {
                if (is_array($value)) {
                    $arr[$key] = self::trim($value, $charlist);
                } else if (is_string($value)) {
                    $arr[$key] = trim($value, $charlist);
                }
            }

            return $arr;
        }

        return $arr;
    }

    /**
     * Removes empty elements from the array.
     *
     * @param array $arr
     *
     * @return array
     */
    public static function removeEmpty(array $arr) : array
    {
        $arr = static::trim($arr);
        $arr = static::removeEmptyArrayElement($arr);

        return $arr;
    }

    /**
     * Helper function thats removes empty elements from array.
     *
     * @param array $arr
     *
     * @return array
     */
    protected static function removeEmptyArrayElement(array $arr) : array
    {
        foreach ($arr as $key => $item) {
            if (is_array($item)) {
                $arr[$key] = static::removeEmptyArrayElement($arr[$key]);
            }

            if (is_numeric($item) && $item == 0) {
                continue;
            }

            if (empty($arr[$key])) {
                unset($arr[$key]);
            }
        }

        return $arr;
    }

    /**
     * Determine if array is associative.
     *
     * @param array $arr
     *
     * @return bool
     */
    public static function isAssoc(array $arr) : bool
    {
        $keys = array_keys($arr);

        return $keys !== array_keys($keys);
    }

    /**
     * Convert a object to an array.
     *
     * @param mixed $source
     *
     * @return array
     */
    public static function toArray($source) : array
    {
        return json_decode(json_encode($source, JSON_FORCE_OBJECT), true);
    }

    /**
     * Convert multi-dimensional array into a flat array with hyphen-separated keys.
     *
     * @param array $arr
     * @param string $separator
     *
     * @return array
     */
    public static function flatten(array $arr, string $separator  = '-')
    {
        $iterator = new \RecursiveIteratorIterator(
            new \RecursiveArrayIterator($arr)
        );

        $result = [];

        foreach ($iterator as $key => $value) {
            for ($i = $iterator->getDepth() - 1; $i >= 0; $i -= 1) {
                $key = $iterator->getSubIterator($i)->key() . $separator  . $key;
            }

            $result[$key] = $value;
        }

        return $result;
    }
}
