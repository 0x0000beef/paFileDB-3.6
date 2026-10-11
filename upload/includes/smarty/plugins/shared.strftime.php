<?php
/**
 * Smarty shared plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Translate a strftime() format string into a date() format string.
 *
 * strftime() is deprecated as of PHP 8.1, so Smarty plugins format dates
 * through date() instead. Only the specifiers reachable from Smarty's own
 * default formats are mapped; unknown specifiers are passed through as-is.
 *
 * @param string $format strftime format string
 * @return string date() format string
 */
function smarty_strftime_format($format)
{
    static $map = array(
        'a' => 'D',  'A' => 'l',  'b' => 'M',  'B' => 'F',
        'c' => 'Y-m-d H:i:s',      'd' => 'd',  'D' => 'm/d/y',
        'e' => 'j',  'F' => 'Y-m-d',      'g' => 'y',  'G' => 'Y',
        'h' => 'M',  'H' => 'H',  'I' => 'h',  'j' => 'j',
        'k' => 'G',  'l' => 'g',  'm' => 'm',
        'p' => 'A',  'P' => 'a',  'r' => 'h:i:s A',
        'R' => 'H:i', 's' => 'U', 'S' => 's',  't' => "\t",
        'T' => 'H:i:s', 'u' => 'N', 'U' => 'U', 'V' => 'W',
        'M' => 'i',
        'w' => 'w',  'W' => 'W',  'x' => 'm/d/y', 'X' => 'H:i:s',
        'y' => 'y',  'Y' => 'Y',  'Z' => 'T',
    );

    $out = '';
    $len = strlen($format);
    for ($i = 0; $i < $len; $i++) {
        $ch = $format[$i];
        if ($ch != '%' || $i + 1 >= $len) {
            // escape characters that are format codes in date()
            if (strpos('\\aAbBcdDeEfFgGhHiIjlLmMnopPrsStTuUvVwWxXyYzZ', $ch) !== false) {
                $out .= '\\' . $ch;
            } else {
                $out .= $ch;
            }
            continue;
        }
        $i++;
        $spec = $format[$i];
        if ($spec == '%') {
            $out .= '%';
        } elseif (isset($map[$spec])) {
            $out .= $map[$spec];
        } elseif ($spec == 'n') {
            $out .= "\n";
        } else {
            $out .= '%' . $spec;
        }
    }
    return $out;
}

/**
 * strftime() replacement built on date().
 *
 * @param string $format strftime format string
 * @param int $timestamp Unix timestamp
 * @return string
 */
function smarty_strftime($format, $timestamp = null)
{
    if ($timestamp === null) {
        $timestamp = time();
    }
    return date(smarty_strftime_format($format), (int)$timestamp);
}

?>
