<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
class Verify extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('login_model','login');
        
        $this->load->model('settings_model', 'setting');
        $this->system = $this->setting->getSystemSettings();
    }

    function index()
    {
        // $code = $this->input->post('code');

        // if( (strtolower($code) != strtolower($_SESSION['random_number'])) OR empty($_SESSION['random_number']) ) {
        // 	redirect(BASE_URL.'login?w=2', 'refresh');
        // }

        //This method will have the credentials validation
        $this->load->library('form_validation');

        $this->form_validation->set_rules('username', 'Username', 'trim|required');
        $this->form_validation->set_rules('password', 'Password', 'trim|required|callback_check_database');

        if ($this->form_validation->run() == FALSE) {
            redirect('auth/login?w=1', 'refresh');
        } else {
            $username = $this->input->post('username');
            $this->login->update_login($username);
            redirect('home', 'refresh');
        }
    }

    function check_database($password)
    {
        //Field validation succeeded.  Validate against database
        $username = $this->input->post('username');
        //query the database
        $result = $this->login->login($username, $password);
        if ($result) {
            $sess_array     = array();

            foreach ($result as $row) {
                $sess_array = array(
                    'user_id'             => $row->user_id,
                    'username'     => $row->user_username,
                    'role_id'        => $row->role_id,
                    'school_id'        => $row->school_id,
                    'language'        => 'indonesia'
                );
                $this->session->set_userdata('logged_in', $sess_array);
            }

            return TRUE;
        } else {
            $this->form_validation->set_message('check_database', 'Invalid username or password');
            return false;
        }
    }

    function logout()
    {
        $this->session->unset_userdata('logged_in');
        $this->session->sess_destroy();
        redirect('auth/login', 'refresh');
    }

    function sendForgetPassword(){
        $email = $this->input->post('email');
        $cond = array(
            'user_email' => $email,
            'user_status' => 1
        );
        $isActiveUser = $this->login->isExistUser($cond);
        if($isActiveUser){
            $token = bin2hex(openssl_random_pseudo_bytes(64));
            $dataForgotPassword = array(
                'forgot_password_email' => $email,
                'forgot_password_token' => $token,
                'forgot_password_date' => date("Y-m-d H:i:s"),
                'forgot_password_status' => 2
            );
            $link = base_url('auth/verify/forgotPassword/'. $token); 
            $header = "Password Reset";
            $text = "Sepertinya anda melupakan password anda. Silahkan klik link berikut untuk melakukan reset password.";
            $dataTemplate = array(
                'header' => $header,
                'text' => $text,
                'btnText' => 'Reset Password',
                'btnLink' => $link
            );
            // $message = "Hi $email, <br> Klik Link Berikut Untuk Melakukan Reset Password Yang Lupa. <br><center><a href='$link'>Klik Disini Untuk Reset Password</a></center>";
            $message = $this->load->view('template/mail', $dataTemplate, TRUE);
            $this->load->helper("Mail_helper");
            if(sendMail($email, 'Forgot Password', $message)){
                $insertData = $this->login->insertRequest($dataForgotPassword);
                if($insertData){
                    $res =  array(
                        'is_success' => true,
                        'message' => "Berhasil, Silahkan Periksa Email Anda."
                    );
                }else{
                    $err = $this->db->error();
                    $message = $err["code"] . "-" . $err["message"];
                    $res =  array(
                        'is_success' => false,
                        'message' => $message,
                    );
                }
            } else {
                ob_start();
                $this->email->print_debugger();
                $error = ob_end_clean();
                $errors[] = $error;
                $res =  array(
                    'is_success' => false,
                    'message' =>  $errors
                );
            }
        }else{
            $res =  array(
                'is_success' => false,
                'message' => "E-mail Tidak Terdaftar",
            );
        }
        echo json_encode($res);
    }

    function forgotPassword(){
        $token = $this->uri->segment(4);
        $cond = array(
            'forgot_password_token' => $token,
            'forgot_password_status' => 2,
        );
        $dataForgotPassword = $this->login->getDataForgotPassword($cond);
        // print_r($dataForgotPassword);die;
        if ($dataForgotPassword){
            $data = array(
                'token' => $token,
                'system' => $this->system
            );
            $this->load->view('auth/forgot_password',$data);
        }else{
            redirect('auth/login');
        }
    }

    function resetPassword(){
        $this->load->library('form_validation');

        $token = $this->uri->segment(4);
        // $this->form_validation->set_rules(
        //     'email',
        //     'Email',
        //     'required|min_length[5]|max_length[30]',
        //     array(
        //         'required'      => 'You have not provided %s.',
        //         'is_unique'     => 'This %s already exists.'
        //     )
        // );
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[12]');
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'trim|required|min_length[8]|max_length[12]|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
            echo json_encode($res);
            exit;
        } else {
            // $email = $this->input->post('email');
            $password = $this->input->post('password');
            $cond = array(
                'forgot_password_token' => $token,
                'forgot_password_status' => 2,
            );
            $dataForgotPassword = $this->login->getDataForgotPassword($cond);
            if ($dataForgotPassword) {
                $this->db->trans_begin();
                $email = $dataForgotPassword[0]['forgot_password_email'];
                $dataUser = array(
                    'user_password' => md5($password),
                    'user_last_update' => date("Y-m-d H:i:s"),
                );
                $cond = array(
                    'user_email' => $email,
                    'user_status' => 1,
                );
                $this->login->updateUser($cond, $dataUser);
                $dataForgotPassword = array(
                    'forgot_password_status' => 1,
                    'forgot_password_last_update' => date("Y-m-d H:i:s"),
                );
                $cond = array(
                    'forgot_password_email' => $email,
                    'forgot_password_status' => 2
                );
                $this->login->updateForgotPassword($cond, $dataForgotPassword);

                if ($this->db->trans_status() === FALSE) {
                    $this->db->trans_rollback();
                    $err = $this->db->error();
                    $res =  array(
                        'is_success' => false,
                        'message' => $err 
                    );
                    echo json_encode($res);
                    exit;
                } else {
                    $this->db->trans_commit();
                    $res =  array(
                        'is_success' => true,
                        'message' => "Berhasil Ubah Password, Silahkan Login Menggunakan Password Yang Baru!"
                    );
                    echo json_encode($res);
                    exit;
                }
            } else {
                redirect('auth/login');
            }
        }
        
    }
}
