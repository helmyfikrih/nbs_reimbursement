<?php

defined('BASEPATH') or exit('No direct script access allowed');

class LanguageLoader
{
    function initialize()
    {
        $ci = &get_instance();
        $ci->load->helper('language');
        if (isset($ci->session->userdata('logged_in')['language'])) {
            $siteLang = $ci->session->userdata('logged_in')['language'];
        } else {
            $siteLang = 'indonesia';
        }
        if ($siteLang) {
            $ci->lang->load('kms', $siteLang);
        } else {
            $ci->lang->load('kms', 'indonesia');
        }
    }
}
