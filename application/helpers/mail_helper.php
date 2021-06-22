<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('sendMail')) {
    function sendMail($to,$subject,$message, $from = null, $alias = null)
    {
        $ci = &get_instance();
        $ci->load->database();
        $ci->load->helper('encrypt');
        $ci->load->model('settings_model', 'setting');
        
        $sys = $ci->setting->getSystemSettings();
        // Konfigurasi email
        $config = [
            'mailtype'  => 'html',
            'charset'   => 'utf-8',
            'protocol'  => 'smtp',
            'smtp_host' => $sys['sys_smtp_host'],
            'smtp_user' => $sys['sys_smtp_user'],  // Email gmail
            'smtp_pass'   => DecryptString($sys['sys_smtp_pass']),  // Password gmail
            'smtp_crypto' => $sys['sys_smtp_crypto'],
            'smtp_port'   => $sys['sys_smtp_port'],
            'crlf'    => "\r\n",
            'newline' => "\r\n"
        ];

        // Load library email dan konfigurasinya
        $ci->load->library('email', $config);

        $from = $from ? $from : $sys['sys_smtp_from'];
        $alias = $alias ? $alias : $sys['sys_smtp_alias'];
        // Email dan nama pengirim
        $ci->email->from($from,$alias);

        // Email penerima
        $ci->email->to($to); // Ganti dengan email tujuan

        // Lampiran email, isi dengan url/path file
        // $this->email->attach('https://masrud.com/content/images/20181215150137-codeigniter-smtp-gmail.png');

        // Subject email
        $ci->email->subject($subject);

        // Isi email
        $ci->email->message($message);

        // Tampilkan pesan sukses atau error
        if ($ci->email->send()) {
            return true;
        } else {
            // echo 'Error! email tidak dapat dikirim.';
            // echo $this->email->print_debugger();
            return $ci->email->print_debugger();
        }
    }
}

