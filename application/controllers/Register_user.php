<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Register_user extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $session_data = $this->session->userdata('logged_in');
        if (empty($session_data)) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('register_user_model', 'register');
        $this->load->model('users_model', 'users');
        $this->load->model('role_model', 'role');
        $this->load->model('designation_model', 'designation');
        $this->load->model('subject_model', 'subject');
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
        $data = array(
            'title' => $this->lang->line('register_title'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'system' => $this->system,
            'menu_allow' => $this->data['menu_allow'],
            'user_allow_menu' => $this->data['user_allow_menu'],
        );
        $this->template->load('default', 'register_user/index', $data);
    }


    public function getList()
    {

        $cond = array();
        $list = $this->register->getList($cond);
        // print_r($this->db->last_query());die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            // $no++;
            $row = array();
            /* $row[] = "<div class='btn-groups'>
            <a href='".site_url("program/edit/$field->id")."' id='$field->id' class='btn btn-sm waves-effect waves-light btn-success edit' data-toggle='tooltip' data-placement='top' title='Edit'>  <i class='fas fa-edit'><span></span></i></a>
            <a href='".site_url("program/detail/$field->id")."' id='$field->id' class='btn btn-sm waves-effect waves-light btn-success detail' data-toggle='tooltip' data-placement='top' title='Detail'>  <i class='fas fa-expand'><span></span></i></a>
            
            </div>";*/
            $btnUpload = "";
            $btnUpload2 = "";
            $btnEdit = "";
            $btnEdit2 = "";
            $btnView = "";
            $btnView2 = "";
            $btnDelete = "";
            $btnDelete2 = "";
            $btnApprove = "";
            $btnApprove2 = "";
            $labelApprove = "";
            $textApprove = "";

            if ($field->email_verify_status == 1) {
                $label = 'success';
                $text = $this->lang->line('register_status_verify');
            }
            if (($field->email_verify_status == 2) || ($field->email_verify_status == null)) {
                $label = 'warning';
                $text = $this->lang->line('register_status_waiting');
            }
            if (($field->mandatory_approve == 1)) {
                if ($field->approve_status == 1) {
                    $labelApprove = 'success';
                    $textApprove = $this->lang->line('register_status_verify');
                } else {
                    $labelApprove = 'warning';
                    $textApprove = $this->lang->line('register_status_waiting');
                }
            }
            $uniqCode = $field->register_uniq_code;
            if (($field->mandatory_approve == 1) && ($field->email_verify_status == 1) && ($field->approve_status != 1)) {
                $btnApprove = '<a class="info" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="approval(\'' . $uniqCode . '\',' . $field->register_id . ')" title="' . $this->lang->line('text_approve') . '">
                            <i class="ace-icon fa fa-check-square-o bigger-130"></i>
                        </a>';
                $btnApprove2 = '<li>
                                    <a href="javascript:;" onclick="approval(\'' . $uniqCode . '\'' . $field->register_id . ')" class="tooltip-error" data-rel="tooltip" title="' . $this->lang->line('text_approve') . '">
                                        <span class="info">
                                            <i class="ace-icon fa fa-check-square-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
            }
            $btn = '<div class="hidden-sm hidden-xs action-buttons">
                    ' . $btnView . $btnUpload . $btnEdit . $btnDelete . $btnApprove . '
                    </div>
                    <div class="hidden-md hidden-lg">
                        <div class="inline pos-rel">
                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                             ' . $btnView2 . $btnUpload2 . $btnEdit2 . $btnDelete2 . $btnApprove2 . '   
                             </ul>
                        </div>
                    </div>';
            $chkBox = '<input type="checkbox" class="ace" /><span class="lbl"></span>';

            // $content = strlen($field->user_desc) > 50 ? substr($field->user_desc, 0, 50) . "..." : $field->user_desc;
            $statusEmail = '<span class="label label-sm label-' . $label . '">' . $text . '</span>';
            $statusApprove = '<span class="label label-sm label-' . $labelApprove . '">' . $textApprove . '</span>';
            $regisDate = date("H:i:s d-m-Y", strtotime($field->register_date));

            // $row[] = $chkBox;
            $row[] = $field->register_full_name;
            $row[] = $field->register_nip;
            $row[] = $field->register_username;
            $row[] = $field->register_email;
            $row[] = $field->school_name;
            $row[] = $field->school_nsm;
            $row[] = $field->role_name;
            $row[] = $field->register_date;
            $row[] = $statusEmail;
            $row[] = $statusApprove;
            $row[] = $field->approve_date;
            $row[] = $btn;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->register->count_new($cond),
            "recordsFiltered" => $this->register->count_filtered_new($cond),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }

    function verify($id = null)
    {
        $uniqCode = $this->input->post('code');
        $cond = array(
            'register_uniq_code' => $uniqCode,
            'register_id' => $id,
            'register_status' => 2,
        );
        $getData = $this->register->getData($cond);
        if ($getData && ($getData[0]['email_verify_status'] == 1)) {
            $this->db->trans_begin();
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
                'designation_id' => 2,
                'subject_id' => $getData[0]['register_subject_id'],
                'ud_nik' => $getData[0]['register_nip'],
                'user_f_name' => $getData[0]['register_full_name']
            );
            $dataRegis = array(
                'register_status' => 1,
                'approve_status' => 1,
                'approve_date' => date("Y-m-d H:i:s"),
                'approve_by' => $this->session->userdata('logged_in')['user_id']
            );

            $this->register->insertUserDetail($dataUserDetail);
            $this->register->update($dataRegis, $cond);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $err = $this->db->error();
                $res = array(
                    'is_success' => false,
                    'message' =>  $err,
                );
            } else {
                $this->db->trans_commit();
                $this->load->helper('Mail_helper');
                $message = "Terimakasih Sudah Menunggu Verifikasi! <br> Akun Anda Sudah Terverifikasi Dan Dapat Digunakan.";
                $dataTemplate = array(
                    'header' => 'Notification',
                    'text' => $message,
                    'btnText' => null,
                    'btnLink' => null
                );
                $message = $this->load->view('template/mail', $dataTemplate, TRUE);
                sendMail($getData[0]['register_email'], 'Notification', $message);
                $res = array(
                    'is_success' => true,
                    'message' => $this->lang->line('register_success_approve'),
                );
            }
        } else {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('text_failed'),
            );
        }
        echo json_encode($res);
    }
}
