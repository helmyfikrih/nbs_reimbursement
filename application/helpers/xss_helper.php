<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('P')) {
    function P($str)
    {
        return htmlentities($str, ENT_QUOTES, 'UTF-8');
    }
}
