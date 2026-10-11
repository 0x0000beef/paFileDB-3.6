<?php
/**
 * PHP 8.x Compatibility File for paFileDB 3.6
 * Provides polyfills for functions removed in PHP 7.0 and 8.0
 */

// each() was removed in PHP 8.0
if (!function_exists('each')) {
    function each(&$array) {
        $key = key($array);
        if ($key === null) {
            return false;
        }
        $result = array($key, current($array));
        next($array);
        return $result;
    }
}

// get_magic_quotes_gpc() was removed in PHP 8.0
if (!function_exists('get_magic_quotes_gpc')) {
    function get_magic_quotes_gpc() {
        return false;
    }
}

// get_magic_quotes_runtime() was removed in PHP 8.0
if (!function_exists('get_magic_quotes_runtime')) {
    function get_magic_quotes_runtime() {
        return false;
    }
}

// mysql_escape_string() was removed in PHP 7.0
if (!function_exists('mysql_escape_string')) {
    function mysql_escape_string($string) {
        return addslashes($string);
    }
}

// mysql_real_escape_string() without connection
if (!function_exists('mysql_real_escape_string')) {
    function mysql_real_escape_string($string, $link = null) {
        return addslashes($string);
    }
}

// eregi() was removed in PHP 7.0
if (!function_exists('eregi')) {
    function eregi($pattern, $string, &$matches = null) {
        return preg_match('/' . addcslashes($pattern, '/') . '/i', $string, $matches);
    }
}

// ereg() was removed in PHP 7.0
if (!function_exists('ereg')) {
    function ereg($pattern, $string, &$matches = null) {
        return preg_match('/' . addcslashes($pattern, '/') . '/', $string, $matches);
    }
}

// split() was removed in PHP 7.0
if (!function_exists('split')) {
    function split($pattern, $string, $limit = -1) {
        return explode($pattern === '' ? ' ' : trim($pattern, '/'), $string, $limit);
    }
}

// create_function() was removed in PHP 8.0
if (!function_exists('create_function')) {
    function create_function($args, $code) {
        return eval('return function(' . $args . ') {' . $code . '};');
    }
}
?>