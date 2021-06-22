<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $session_data = $this->session->userdata('logged_in');
        if (empty($session_data)) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('profile_model','profile');
        $this->load->model('users_model','users');
        $this->load->model('settings_model', 'setting');
        $this->system = $this->setting->getSystemSettings();
        $this->sessionUserDetail = $this->users->sessionUserDetail();
        $this->menu_body     = $this->Menu_model->getmenu($session_data['user_id'], $session_data['username']);
        
        // Menu Access Role
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
        $this->load->model('subject_model','subject');
        $dataSubject = $this->subject->getAllSubject();
        $data = array(
            'title' => $this->lang->line('profile_title'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'dataSubject' => $dataSubject,
            'system' => $this->system
        );
        // print_r($data);die;
        $this->template->load('default', 'profile/index', $data);
    }

    public function changeAvatar(){
        $id = $this->session->userdata('logged_in')['user_id'];
        $username = $this->session->userdata('logged_in')['username'];
        $config['upload_path'] = './assets/images/avatars/';
        $config['allowed_types'] = 'png|jpg|jpeg';
        $config['overwrite'] = TRUE;
        $config['max_size']     = '4000';
        // $config['max_width'] = '2048';
        // $config['max_height'] = '1536';
        $nmfile = $id . "_" . $username;
        $config['file_name'] = $nmfile;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('avatar')) {

            $this->session->set_flashdata("pesan", "<div class=\"col-md-12\"><div class=\"alert alert-danger\" id=\"alert\">Update Profile Picture Gagal Dilakukan !!</br>" . $this->upload->display_errors() . "</div></div>");
            $res = array(
                'is_success' => false,
                'message' => $this->upload->display_errors()
            );
        } else {

            //Image Resizing
            if($this->upload->file_size>=700){
                $config['source_image'] = $this->upload->upload_path . $this->upload->file_name;
                $config['maintain_ratio'] = FALSE;
                $config['width'] = 540;
                $config['height'] = 720;
                $this->load->library('image_lib', $config);
                $this->image_lib->resize();
                // if (!$this->image_lib->resize()) {
                //     $msg = $this->image_lib->display_errors;
                // }
            }

            $filedata = $this->upload->data();
            $updateProfile = $this->profile->changeAvatar($id, $filedata);
            if($updateProfile){
                $res = array(
                    'is_success' => true,
                    'message' => $this->lang->line('profile_success_change_ava'),
                    'imgName' =>  $filedata['file_name']
                );
            }else{
                $err = $this->db->error();
                $msg = $err["code"] . "-" . $err["message"];
                $res = array(
                    'is_success' => false,
                    'message' =>  $msg
                );
            }
           
        }
        echo json_encode($res);
    }

    public function update(){
        $this->load->library('form_validation');

        $this->form_validation->set_rules('type', 'type', 'required');
        if($this->input->post('type')=='info'){
           $res = $this->updateInfo();
        }
        if($this->input->post('type') == 'changePassword'){
            $res = $this->changePassword();
        }
        if ($this->input->post('type') == 'changeUsername') {
            $res = $this->changeUsername();
        }
        if ($this->input->post('type') == 'changeEmail') {
            $res = $this->changeEmail();
        }
        echo json_encode($res);
    }

    public function changePassword(){
        $this->form_validation->set_rules('oldPassword', $this->lang->line('profile_old_password'), 'trim|required|callback_oldPassword_check');
        $this->form_validation->set_rules('newPassword', $this->lang->line('profile_new_password'), 'trim|required');
        $this->form_validation->set_rules('confirmPassword', $this->lang->line('profile_conf_password'), 'trim|required|matches[newPassword]');
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
        } else {
            $data = array(
                'user_password' => md5($this->input->post('newPassword')),
                'user_last_update' => date('Y-m-d H:i:s')
            );
            $this->load->model('login_model', 'login');
            $changePassword = $this->login->changePassword($data);
            if ($changePassword) {
                $res = array(
                    'is_success' => true,
                    'message' => $this->lang->line('profile_success_change_password'),
                );
            } else {
                $err = $this->db->error();
                $msg = $err["code"] . "-" . $err["message"];
                $res = array(
                    'is_success' => false,
                    'message' =>  $msg
                );
            }
        }
        return $res;
    }

    public function oldPassword_check($password){
        $this->load->model('login_model','login');
        $oldPassword = $this->login->getUserPassword();
        if($oldPassword[0]['user_password'] == md5($password)){
            return true;
        } else {
            $this->form_validation->set_message('oldPassword_check', $this->lang->line('profile_warning_dif_old_password'));
            return false;
        }
    }

    public function updateInfo(){
        $this->form_validation->set_rules('fullName', $this->lang->line('profile_full_name'), 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
        } else {
            $params = $this->input->post();
            $updateProfile = $this->profile->updateProfile($params);
            if ($updateProfile) {
                $res = array(
                    'is_success' => true,
                    'message' => $this->lang->line('profile_success_change_profile'),
                );
            } else {
                $err = $this->db->error();
                $msg = $err["code"] . "-" . $err["message"];
                $res = array(
                    'is_success' => false,
                    'message' =>  $msg
                );
            }
        }
        return $res;
    }

    function changeUsername(){
        $this->form_validation->set_rules('username',  $this->lang->line('profile_username'), 'trim|required|is_unique[kms_user.user_username]');
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
        } else {
            $params = $this->input->post();
            $changeUsername = $this->profile->changeUsername($params);
            if ($changeUsername) {
                $res = array(
                    'is_success' => true,
                    'message' => $this->lang->line('profile_success_change_username'),
                );
                $sess_array = array(
                    'user_id'             => $this->session->userdata('logged_in')['user_id'],
                    'username'     => $params['username'],
                    'role_id'        => $this->session->userdata('logged_in')['role_id'],
                    'school_id'        => $this->session->userdata('logged_in')['school_id'],
                    'language'        => $this->session->userdata('logged_in')['language'],
                );
                $this->session->set_userdata('logged_in', $sess_array);
            } else {
                $err = $this->db->error();
                $msg = $err["code"] . "-" . $err["message"];
                $res = array(
                    'is_success' => false,
                    'message' =>  $msg
                );
            }
        }
        return $res;
    }

    public function removeAvatar(){
        $remove = $this->profile->removeAvatar();
        if ($remove) {
            $res = array(
                'is_success' => true,
                'imgName' => 'avatar2.png',
                'message' => $this->lang->line('profile_success_remove_avatar'),
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

    function changeEmail(){
        $this->form_validation->set_rules('email', 'E-mail', 'trim|required|is_unique[kms_user.user_email]');
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
        } else {
            $params = $this->input->post();
            $changeEmail = $this->profile->changeEmail($params);
            $oldEmail = $params['oldEmail'] ? $params['oldEmail'] : $params['email'];
            $newEmail = $params['email'];
            $username = $this->sessionUserDetail['username'];
            $this->load->helper('mail_helper');
            $message = "Hi $username, <br> Anda Baru Saja Merubah Alamat E-mail Anda Menjadi $newEmail.";
            if ($changeEmail) {
                $res = array(
                    'is_success' => true,
                    'message' => $this->lang->line('profile_success_change_email'),
                );
                $dataTemplate = array(
                    'header' => 'Notification',
                    'text' => $message,
                    'btnText' => null,
                    'btnLink' => null
                );
                $message = $this->load->view('template/mail', $dataTemplate, TRUE);
                $sendMail = sendMail($oldEmail, 'Notifikasi', $message);
            } else {
                $err = $this->db->error();
                $msg = $err["code"] . "-" . $err["message"];
                $res = array(
                    'is_success' => false,
                    'message' =>  $msg
                );
            }
        }
        return $res;
    }

    public function checkUsername()
    {
        $username = $this->input->post('username');
        $isExist = $this->profile->isExistusername($username);
        if ($isExist) {
            $res = array(
                'is_success' => true,
                'isExist' =>  true
            );
        } else {
            $res = array(
                'is_success' => true,
                'isExist' =>  false
            );
        }
        echo json_encode($res);
    }

    public function checkEmail()
    {
        $email = $this->input->post('email');
        $isExist = $this->profile->isExistEmail($email);
        if ($isExist) {
            $res = array(
                'is_success' => true,
                'isExist' =>  true
            );
        } else {
            $res = array(
                'is_success' => true,
                'isExist' =>  false
            );
        }
        echo json_encode($res);
    }

}
