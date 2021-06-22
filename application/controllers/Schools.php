<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Schools extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $session_data = $this->session->userdata('logged_in');
        if (empty($session_data)) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('schools_model', 'schools');
        $this->load->model('users_model', 'users');
        $this->load->model('role_model', 'role');
        $this->load->model('designation_model', 'designation');
        $this->load->model('subject_model', 'subject');
        $this->load->model('settings_model', 'setting');

        $this->system = $this->setting->getSystemSettings();
        $this->sessionUserDetail = $this->users->sessionUserDetail();
        $this->dataRole = $this->role->getAllRole();
        $this->dataDesignation = $this->designation->getAllDesignation();
        $this->dataSubject = $this->subject->getAllSubject();
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
            'title' => $this->lang->line('school_title'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'system' => $this->system,
            'menu_allow' => $this->data['menu_allow'],
            'user_allow_menu' => $this->data['user_allow_menu'],
        );
        $this->template->load('default', 'schools/index', $data);
    }

    public function create()
    {
        $data = array(
            'title' => $this->lang->line('school_create'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'dataRole' => $this->dataRole,
            'dataDesignation' => $this->dataDesignation,
            'dataSubject' => $this->dataSubject,
            'system' => $this->system
        );
        if ((!in_array($this->data['menu_allow'] . '_add', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('warning_access'),
            );
            $this->template->load('default', '404', $data);
        } else {
            $this->template->load('default', 'schools/create', $data);
        }
    }

    public function check_nsm(){
        $school_nsm = $this->input->post('school_nsm');
        $isExist = $this->schools->isExistNsm($school_nsm);
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

    public function save()
    {

        if ((!in_array($this->data['menu_allow'] . '_add', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('warning_access'),
            );
            echo json_encode($res);
            exit;
        }

        $inserSchool = null;
        $updateSchool = null;
        $state = null;
        $schoolEditId = $this->input->post('school_id');
        $school_nsm =  $this->input->post('school_nsm');
        $userId = $this->session->userdata('logged_in')['user_id'];
        $school_name =  $this->input->post('school_name');
        $school_type =  $this->input->post('school_type');
        $school_address =  $this->input->post('school_address');
        $school_phone =  $this->input->post('school_phone');
        $school_status =  $this->input->post('school_status');

        $dataSchool = array(
            'school_name' => $school_name,
            'school_type' => $school_type,
            'school_nsm' => $school_nsm,
            'school_address' => $school_address,
            'school_phone' => $school_phone,
            'school_status' => $school_status
        );

        $cond = array(
            'school_id' => $schoolEditId
        );
        if ($schoolEditId) {
            $state = "Edit";
            $updateSchool =  $this->schools->updateSchool($dataSchool, $cond);
            $msg =  $this->lang->line('school_success_edit');
        } else {
            $state = "Create";
            $dataSchool['school_created_date'] = date("Y-m-d H:i:s");
            $dataSchool['school_created_by'] =  $userId;
            $inserSchool =  $this->schools->insertSchool($dataSchool);
            $msg =  $this->lang->line('school_success_create');
        }
        if (($inserSchool) || ($updateSchool)) {
            $res = array(
                'is_success' => true,
                'message' =>  $msg,
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

    public function getList()
    {

        $cond = array(
            'school_status !=' => null
        );
        $list = $this->schools->getList($cond);
        // print_r($list);die;
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
            $btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('schools/view/' . $field->school_id . '/' . $field->school_nsm) . '" title="' . $this->lang->line('school_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
            $btnView2 = '<li>
                                    <a href="' . base_url('schools/view/' . $field->school_id . '/' . $field->school_nsm) . '"  class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('school_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
            if ((in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
                $btnEdit = '<a class="green" data-rel="tooltip" data-placement="bottom" href="' . base_url('schools/edit/' . $field->school_id . '/' . $field->school_nsm) . '" title="' . $this->lang->line('school_edit') . '">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>';
                $btnEdit2 = '<li>
                                        <a  href="' . base_url('schools/edit/' . $field->school_id . '/' . $field->school_nsm) . '" class="tooltip-success" data-rel="tooltip" title="' . $this->lang->line('school_edit') . '">
                                            <span class="green">
                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                            </span>
                                        </a>
                                    </li>';
            }
            if ($field->school_status == 1) {
                $label = 'success';
                $text = $this->lang->line('school_status_active');
            }
            if ($field->school_status == 2) {
                $label = 'warning';
                $text = 'Menunngu Validasi';
            }
            if ($field->school_status == 4) {
                $label = 'danger';
                $text = 'Rejected';
            }
            if ($field->school_status == 0) {
                $label = 'danger';
                $text = $this->lang->line('school_status_inactive');
            }

            // $btnDelete = '<a class="red" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="approval(0,' . $field->u_id . ')" title="Hapus user">
            //                 <i class="ace-icon fa fa-trash-o bigger-130"></i>
            //             </a>';
            // $btnDelete2 = '<li>
            //                         <a href="javascript:;" onclick="approval(0,' . $field->u_id . ')" class="tooltip-error" data-rel="tooltip" title="Hapus user">
            //                             <span class="red">
            //                                 <i class="ace-icon fa fa-trash-o bigger-120"></i>
            //                             </span>
            //                         </a>
            //                     </li>';
            $btn = '<div class="hidden-sm hidden-xs action-buttons">
                    ' . $btnView . $btnUpload . $btnEdit . $btnDelete . '
                    </div>
                    <div class="hidden-md hidden-lg">
                        <div class="inline pos-rel">
                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                             ' . $btnView2 . $btnUpload2 . $btnEdit2 . $btnDelete2 . '   
                             </ul>
                        </div>
                    </div>';
            $chkBox = '<input type="checkbox" class="ace" /><span class="lbl"></span>';

            // $content = strlen($field->user_desc) > 50 ? substr($field->user_desc, 0, 50) . "..." : $field->user_desc;
            $status = '<span class="label label-sm label-' . $label . '">' . $text . '</span>';
            // $userDate = date("H:i:s d-m-Y", strtotime($field->user_created_date));
            // if ($field->ud_img_name) {
            //     $avatar = $field->ud_img_name;
            // } else {
            //     $avatar = "avatar2.png";
            // }
            // $row[] = $chkBox;
            // $row[] = '<img  width="150" height="150" class="center img-thumbnail" alt="Alex Does avatar" src="' . base_url() . 'assets/images/avatars/' . $avatar . '">';
            $row[] = p($field->school_name);
            $row[] = p($field->school_nsm);
            $row[] = P($field->school_type);
            $row[] = P($field->school_address);
            $row[] = $status;
            $row[] = $btn;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->schools->count_new($cond),
            "recordsFiltered" => $this->schools->count_filtered_new($cond),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }

    public function view()
    {
        $school_id = $this->uri->segment(3);
        $school_nsm = $this->uri->segment(4);
        $schoolDetail = $this->schools->getOneSchool($school_id, $school_nsm);

        $data = array(
            'title' => $schoolDetail[0]['school_name'],
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'schoolDetail' => $schoolDetail,
            'system' => $this->system
        );
        if ($schoolDetail) {
            $this->template->load('default', 'schools/view', $data);
        } else {
            $this->template->load('default', '404', $data);
        }
    }

    public function edit()
    {
        $school_id = $this->uri->segment(3);
        $school_nsm = $this->uri->segment(4);
        $schoolDetail = $this->schools->getOneSchool($school_id, $school_nsm);

        $data = array(
            'title' => $this->lang->line('school_edit'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'schoolDetail' => $schoolDetail,
            'system' => $this->system
        );
        if ($schoolDetail) {
            if ((!in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
                $res = array(
                    'is_success' => false,
                    'message' => $this->lang->line('warning_access'),
                );
                $this->template->load('default', '404', $data);
            } else {
                $this->template->load('default', 'schools/edit', $data);
            }
        } else {
            $this->template->load('default', '404', $data);
        }
    }
}
