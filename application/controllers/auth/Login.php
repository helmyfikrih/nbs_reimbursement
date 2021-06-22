<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $session_data = $this->session->userdata('logged_in');

        if (!empty($session_data)) {
            redirect('home', 'refresh');
        }

        $this->load->model('settings_model', 'setting');
        $this->system = $this->setting->getSystemSettings();
    }

    public function index()
    {
        $pesan = '';
        $w = $this->input->get('w');
        if ($w == 1) {
            $pesan = "Wrong Username OR Password";
        } else {
            $pesan = "Wrong Type Code";
        }
        $data = array(
            'message' => $pesan,
            'system' => $this->system,
            'userRole' =>$this->db->query("SELECT * FROM kms_user_role WHERE role_name LIKE '%guru%' OR role_name LIKE '%murid%'")->result_array(),
            'subjects' =>$this->db->query("SELECT * FROM kms_subject")->result_array(),
            'schools' =>$this->db->query("SELECT * FROM kms_schools WHERE school_status=1")->result_array()
        ); 
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        $this->load->view('auth/login', $data);
    }
}
