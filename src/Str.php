<?php

namespace Helpers;

class Str
{
    /**
     * Check if a string contains another string/set of strings.
     *
     * @param string $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    public static function contains(string $haystack, $needles) : bool
    {
        foreach ((array) $needles as $needle) {
            if ($needle != '' && mb_strpos($haystack, $needle) !== false) {
                return true;
            }
        }

        return false;
    }
}
