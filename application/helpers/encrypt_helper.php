<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('EncryptString')) {
    function EncryptString($string = null)
    {
        $ci = &get_instance();
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $encryption_iv = '2005199607081996';
        $encryption_key = "kmsschool"; 
        return openssl_encrypt(
            $string,
            $ciphering,
            $encryption_key,
            $options,
            $encryption_iv
        ); 
    }
}

if (!function_exists('DecryptString')) {
    function DecryptString($string = null)
    {
        $ci = &get_instance();
        $ciphering = "AES-128-CTR";
        $iv_length = openssl_cipher_iv_length($ciphering);
        $options = 0;
        $decryption_iv = '2005199607081996';
        $decryption_key = "kmsschool"; 
        return openssl_decrypt(
            $string,
            $ciphering,
            $decryption_key,
            $options,
            $decryption_iv
        ); 
    }
}
