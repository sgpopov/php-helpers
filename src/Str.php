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

    /**
     * Return string length.
     *
     * @param string $input
     *
     * @return int
     */
    public static function length(string $input) : int
    {
        return mb_strlen($input);
    }

    /**
     * Returns URL friendly slug version of input string:
     *  - converts all alpha chars to lowercase
     *  - converts any char that is not digit, letter or - into - symbols into "-"
     *  - not allow two "-" chars continued, converte them into only one syngle "-"
     *
     * For example: 'This iS a sImpLe TEST' => 'this-is-a-simple-tests'
     *
     * @param string $input
     * @param string $separator
     *
     * @return string
     */
    public static function slug(string $input, $separator = '-') : string
    {
        // Make sure the string is UTF-8 encoded.
        if ($input !== mb_convert_encoding(mb_convert_encoding($input, 'UTF-32', 'UTF-8'), 'UTF-8', 'UTF-32')) {
            $input = mb_convert_encoding($input, 'UTF-8', mb_detect_encoding($input));
        }

        // Convert all applicable characters to HTML entities.
        $input = htmlentities($input, ENT_NOQUOTES, 'UTF-8');

        // Converts all special characters to their base form (i.e. ü -> u).
        $input = preg_replace('`&([a-z]{1,2})(acute|uml|circ|grave|ring|cedil|slash|tilde|caron|lig);`i', '\1', $input);

        // Convert all HTML entities to their applicable characters.
        $input = html_entity_decode($input, ENT_NOQUOTES, 'UTF-8');

        // Convert all spaces to hyphens (or whatever the separator) as well as
        // repating hyphens (or whatever the separator) will be reduce to just one.
        $input = preg_replace(['`[^a-z0-9]`i', '`['. $separator .']+`'], $separator, $input);

        // Trim the string and convert it to lowercase.
        $input = strtolower(trim($input, $separator));

        return $input;
    }
}
