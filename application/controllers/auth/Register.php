<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $session_data = $this->session->userdata('logged_in');
        $this->load->model('register_model', 'register');
        $this->load->library('form_validation');
        $this->load->model('settings_model', 'setting');
        $this->load->helper('Mail_helper');
        $this->system = $this->setting->getSystemSettings();
    }

    public function index()
    {
        $this->form_validation->set_rules(
            'email',
            'Email',
            'required|min_length[5]|max_length[30]|is_unique[m_user.user_email]|is_unique[m_user_register.register_email]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
            echo json_encode($res);
            exit;
        }
        $this->form_validation->set_rules(
            'username',
            'Username',
            'trim|required|min_length[5]|max_length[12]|is_unique[m_user.user_username]',
            array(
                'required'      => 'You have not provided %s.',
                'is_unique'     => 'This %s already exists.'
            )
        );
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
            echo json_encode($res);
            exit;
        }
        $this->form_validation->set_rules('school', 'Sekolah', 'trim|required');
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
            echo json_encode($res);
            exit;
        }
        $this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[8]|max_length[12]');
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
            echo json_encode($res);
            exit;
        }
        $this->form_validation->set_rules('confirmPassword', 'Confirm Password', 'trim|required|min_length[8]|max_length[12]|matches[password]');
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
        } else {
            $insert = null;
            $uniqid = uniqid('kms_');
            $email = $this->input->post('email');
            $school = $this->input->post('school');
            $subject = $this->input->post('subject');
            $name = $this->input->post('fullName');
            $username = $this->input->post('username');
            $password = $this->input->post('password');
            $agreement = $this->input->post('agreement');
            if ($this->system['active_register_role'] == 1) {
                $role = $this->input->post('role');
                $nip = $this->input->post('nip');
            } else {
                $role = 4;
                $nip = null;
            }
            $approve = $role == 4 ? 0 : 1;
            $url = base_url('auth/register/verify/' . $uniqid . '/' . $username);
            $data = array(
                'register_school_id' => $school,
                'register_email' => $email,
                'register_full_name' => $name,
                'register_nip' => $nip,
                'register_role' => $role,
                'register_subject_id' => $subject,
                'register_username' => $username,
                'register_password' => $password,
                'register_agreement' => $agreement,
                'register_uniq_code' => $uniqid,
                'register_date' => date("Y-m-d H:i:s"),
                'register_status' => 2,
                'mandatory_approve' => $approve,
            );

            // $message = "Hi $name, Terimakasih Telah Melakukan Registrasi.<br><br>Silahkan Klik Untuk Melakukan Verifikasi Agar Dapat Login.<br><br> <strong><a href='$url' target='_blank' rel='noopener'>Verify</a></strong>.";
            $header = "Register Verification";
            $text = "Hi $username, Terimakasih Telah Melakukan Registrasi.<br><br>Silahkan Klik Untuk Melakukan Verifikasi Agar Dapat Login Menggunakan System.";
            $dataTemplate = array(
                'header' => $header,
                'text' => $text,
                'btnText' => 'Verification',
                'btnLink' => $url
            );
            $message = $this->load->view('template/mail', $dataTemplate, TRUE);
            $sendEmail = sendMail($email, 'E-mail verification', $message);
            if ($sendEmail) {
                $insert = $this->register->insertRegister($data);
            }
            if ($sendEmail && $insert) {
                if ($role == 4) {
                    $res =  array(
                        'is_success' => true,
                        'message' => "Berhasil Register, Silahkan verifikasi Email Anda."
                    );
                } else {
                    $res =  array(
                        'is_success' => true,
                        'message' => "Berhasil Register, Silahkan verifikasi Email Anda Dan Tunggu Verifikasi Oleh Admin."
                    );
                }
            } else {
                $err = $this->db->error();
                $message = $err["code"] . "-" . $err["message"];
                $res =  array(
                    'is_success' => false,
                    'message' => $message,
                );
            }
        }
        echo json_encode($res);
    }

    function verify()
    {
        $uniqid = $this->uri->segment(4);
        $username = $this->uri->segment(5);

        $cond = array(
            'register_uniq_code' => $uniqid,
            'register_username' => $username,
            'register_status' => 2,
        );

        $getData = $this->register->getData($cond);
        $registerStatus = $getData[0]['mandatory_approve'] == 0 ? 1 : 2;
        if ($getData && ($getData[0]['email_verify_status'] != 1)) {
            $this->db->trans_begin();
            $this->register->verifyEmail($cond, $registerStatus);
            if ($getData[0]['mandatory_approve'] == 1) {
                $message = "Thank you for verify your Email! Please Wait For Admin verification And You Will Get Email Notification After Approved By Admin!";
            } else {

                $message = "Thank you for verify your Email! Now You Can Logged In.";
                $dataUser = array(
                    'school_id' => $getData[0]['register_school_id'],
                    'role_id' => $getData[0]['register_role'],
                    'user_username' => $getData[0]['register_username'],
                    'user_password' => md5($getData[0]['register_password']),
                    'user_email' => $getData[0]['register_email'],
                    'user_created_date' => $getData[0]['register_date'],
                    'user_status' => 1,
                );
                $this->register->insertUser($dataUser);
                $dataUserDetail = array(
                    'user_id' => $this->db->insert_id(),
                    'ud_nik' => $getData[0]['register_nip'],
                    'user_f_name' => $getData[0]['register_full_name']
                );
                $this->register->insertUserDetail($dataUserDetail);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $err = $this->db->error();
            } else {
                $this->db->trans_commit();
                $dataTemplate = array(
                    'header' => "Notification",
                    'text' => $message,
                    'btnText' => null,
                    'btnLink' => null
                );
                // $message = "Hi $email, <br> Klik Link Berikut Untuk Melakukan Reset Password Yang Lupa. <br><center><a href='$link'>Klik Disini Untuk Reset Password</a></center>";
                $data = array(
                    'system' => $this->system,
                    'message' =>  $message
                );
                $this->load->view('auth/email_confirmation', $data);
                $message = $this->load->view('template/mail', $dataTemplate, TRUE);
                sendMail($getData[0]['register_email'], 'Notification', $message);
            }
        } else {
            redirect('auth/login');
        }
    }

    function resendEmailVerify()
    {
        $email = $this->input->post('email');
        $cond = array(
            'register_email' => $email,
            'register_status' => 2,
        );
        $getRegisterData = $this->register->getData($cond);
        if ($getRegisterData && ($getRegisterData[0]['email_verify_status'] != 1)) {
            $maxTimeWait = 5; //in Minutes
            $lastDateResend = strtotime($getRegisterData[0]['last_date_resend_verify']);
            $now = strtotime(date("Y-m-d H:i:s"));
            if ($lastDateResend) {
            }
            $diffTIme = $now - $lastDateResend;
            $diffMinute = floor(abs($diffTIme / (60)));
            if ($diffMinute < $maxTimeWait) {
                $remainTime = $maxTimeWait - $diffMinute;
                $res =  array(
                    'is_success' => false,
                    'message' => "Tunggu $remainTime Menit Lagi!"
                );
                echo json_encode($res);
                exit;
            }
        }
        if ($getRegisterData && ($getRegisterData[0]['email_verify_status'] != 1)) {
            $email = $getRegisterData[0]['register_email'];
            $username = $getRegisterData[0]['register_username'];
            $uniqid = $getRegisterData[0]['register_uniq_code'];
            $url = base_url('auth/register/verify/' . $uniqid . '/' . $username);
            // $message = "Hi $username, Terimakasih Telah Melakukan Registrasi.<br><br>Silahkan Klik Untuk Melakukan Verifikasi Agar Dapat Login.<br><br> <strong><a href='$url' target='_blank' rel='noopener'>Verify</a></strong>.";
            $header = "Register Verification";
            $text = "Hi $username, Terimakasih Telah Melakukan Registrasi.<br><br>Silahkan Klik Untuk Melakukan Verifikasi Agar Dapat Login Menggunakan System.";
            $dataTemplate = array(
                'header' => $header,
                'text' => $text,
                'btnText' => 'Verification',
                'btnLink' => $url
            );
            $message = $this->load->view('template/mail', $dataTemplate, TRUE);
            $sendEmail = sendMail($email, 'E-mail verification', $message);
            if ($sendEmail) {
                $data = array(
                    'last_date_resend_verify' => date("Y-m-d H:i:s")
                );
                $cond = array(
                    'register_email' =>  $email,
                    'register_username' => $username
                );
                $this->register->updateRegister($cond, $data);
                $res =  array(
                    'is_success' => true,
                    'message' => "Berhasil, Silahkan Periksa Email Anda."
                );
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
        } else {
            if (($getRegisterData[0]['email_verify_status'] == 1) && ($getRegisterData[0]['approve_status'] != 1)) {
                $res =  array(
                    'is_success' => false,
                    'message' => "E-mail Sudah Terverifikasi dan Sedang Menunggu Verifikasi Admin."
                );
            }
            $isExistEmail = $this->db->query("SELECT * FROM m_user WHERE user_email = '$email'")->result_array();
            if ($isExistEmail) {
                $res =  array(
                    'is_success' => false,
                    'message' => "E-mail Sudah Digunakan."
                );
            }
        }
        echo json_encode($res);
    }
}
