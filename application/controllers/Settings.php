<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Settings extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $session_data = $this->session->userdata('logged_in');
        if (empty($session_data)) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('users_model', 'users');
        $this->load->model('settings_model', 'setting');
        $this->system = $this->setting->getSystemSettings();
        $this->sessionUserDetail = $this->users->sessionUserDetail();
        $this->menu_body     = $this->Menu_model->getmenu($session_data['user_id'], $session_data['username']);
       

        // Menu Access subject
        $urlname    = strtolower($this->router->fetch_class());
        $menu_id       = $this->Menu_model->idMenu($urlname);
        $user_allow = $this->Menu_model->UserAllow($session_data['role_id']);
        $user_allow_menu = explode(",", $user_allow[0]['role_allow_menu']);
        $this->data['menu_allow'] = '';
        $this->data['user_allow_menu'] = $user_allow_menu;
        if (@in_array($menu_id[0]['menu_id'], $user_allow_menu)) {
            $this->data['menu_allow'] = 'level_' . $menu_id[0]['menu_id'];
        } else {
            redirect('home', 'refresh');
        }
    }

    public function index()
    {
        $data = array(
            'title' => $this->lang->line('sys_title'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'system' => $this->system
        );
        $this->template->load('default', 'settings/index', $data);
    }

    public function saveGeneral(){
        $application_name = $this->input->post('application_name');
        $header_name = $this->input->post('header_name');
        $footer_text = $this->input->post('footer_text');
        $footer_year = $this->input->post('footer_year');
        $register_role = $this->input->post('registerRole');
        $sys_info = $this->input->post('sys_info');
        $data = array(
            'setting_id' => 1,
            'application_name' => $application_name,
            'header_name' => $header_name,
            'footer_text' => $footer_text,
            'footer_year' => $footer_year,
            'sys_info' => $sys_info,
        );

        if($register_role){
            $data['active_register_role'] = 1;
        } else {
            $data['active_register_role'] = 0;
        }

        if($this->setting->saveGeneral($data)){
            $res = array(
                'is_success' => true,
                'message' => $this->lang->line('sys_success_save'),
            );
        } else {
            $err = $this->db->error();
            $msg = $err["code"] . "-" . $err["message"];
            $res = array(
                'is_success' => false,
                'message' =>  $msg
            );
        }

        echo json_encode($res);
    }

    public function saveLogo(){
        $logo_header = $_FILES['logo_header'];
        $logo_icon = $_FILES['logo_icon'];
        $res = array(
            'is_success' => false,
            'message' => $this->lang->line('warning_no_file_choosen')
        );
        if($logo_header['error']==0){
            $res = $this->uploadImg('logo', 'logo_header');
        }
        if ($logo_icon['error'] == 0) {
            $res = $this->uploadImg('icon', 'logo_icon');
        }
        echo json_encode($res);
        
    }

    public function saveSMTP()
    {
        $sys_smtp_host = $this->input->post('sys_smtp_host');
        $sys_smtp_user = $this->input->post('sys_smtp_user');
        $sys_smtp_pass = $this->input->post('sys_smtp_pass');
        $sys_smtp_crypto = $this->input->post('sys_smtp_crypto');
        $sys_smtp_port = $this->input->post('sys_smtp_port');
        $sys_smtp_from = $this->input->post('sys_smtp_from');
        $sys_smtp_alias = $this->input->post('sys_smtp_alias');
        $data = array(
            'sys_smtp_host' => $sys_smtp_host,
            'sys_smtp_user' => $sys_smtp_user,
            'sys_smtp_pass' => EncryptString($sys_smtp_pass),
            'sys_smtp_crypto' => $sys_smtp_crypto,
            'sys_smtp_port' => $sys_smtp_port,
            'sys_smtp_from' => $sys_smtp_from,
            'sys_smtp_alias' => $sys_smtp_alias,
        );


        if ($this->setting->saveGeneral($data)) {
            $res = array(
                'is_success' => true,
                'message' => $this->lang->line('sys_success_save'),
            );
        } else {
            $err = $this->db->error();
            $msg = $err["code"] . "-" . $err["message"];
            $res = array(
                'is_success' => false,
                'message' =>  $msg
            );
        }

        echo json_encode($res);
    }

    function uploadImg($nmFile, $inputFile){
        $config['upload_path'] = './assets/images/icon/';
        $config['allowed_types'] = 'jpg|jpeg|gif|png';
        $config['overwrite'] = TRUE;
        $config['max_size']     = '2000';
        // $config['max_width'] = '2048';
        // $config['max_height'] = '1536';
        $config['file_name'] = $nmFile;
        $this->load->library('upload', $config);
        if (!$this->upload->do_upload($inputFile)) {
            $res = array(
                'is_success' => false,
                'message' => $this->upload->display_errors()
            );
            return $res;
        } else {
            //Image Resizing
            $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
            $config['maintain_ratio'] = FALSE;
            $config['width'] = 60;
            $config['height'] = 60;

            $this->load->library('image_lib', $config);

            if (!$this->image_lib->resize()) {
                $res = array(
                    'is_success' => false,
                    'message' => $this->image_lib->display_errors('', '')
                );
                return $res;
            } else {
                $data = array(
                    $inputFile => $this->upload->file_name
                );
                $this->setting->updateSetting($data);
                $res = array(
                    'is_success' => true,
                    'message' => $this->lang->line('sys_success_save'),
                    'imgName' => $this->upload->file_name,
                    'imgType' => $inputFile
                );
            }

            return $res;
        }
    }

}
