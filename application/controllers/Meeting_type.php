<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Meeting_type extends CI_Controller
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
        $this->load->model('meet_type_model', 'meet');
        $this->load->model('settings_model', 'setting');
        $this->system = $this->setting->getSystemSettings();
        $this->sessionUserDetail = $this->users->sessionUserDetail();
        $this->menu_body     = $this->Menu_model->getmenu($session_data['user_id'], $session_data['username']);


        // Menu Access MeetType
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
            'title' => $this->lang->line('meettype_title'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'system' => $this->system
        );
        $this->template->load('default', 'meeting_type/index', $data);
    }

    public function getList()
    {
        $cond = array();
        $list = $this->meet->getList($cond);
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
            $btnDelete = "";
            $btnDelete2 = "";
            $btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('user/view/' . $field->meetType_id . '/' . $field->meetType_name) . '" title="Lihat user">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
            $btnView2 = '<li>
                                    <a href="' . base_url('user/view/' . $field->meetType_id . '/' . $field->meetType_name) . '"  class="tooltip-info" data-rel="tooltip" title="Lihat user">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';

            $btnView = "";
            $btnView2 = "";
            $btnEdit = '<a class="green" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="editData(' . $field->meetType_id . ')" title="' . $this->lang->line('meettype_edit') . '">
                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                        </a>';
            $btnEdit2 = '<li>
                                    <a  href="javascript:;" onclick="editData(' . $field->meetType_id . ')"  class="tooltip-success" data-rel="tooltip" title="' . $this->lang->line('meettype_edit') . '">
                                        <span class="green">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';

            $btnDelete = '<a class="red" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="deleteData(' . $field->meetType_id . ')" title="' . $this->lang->line('meettype_delete') . '">
                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                        </a>';
            $btnDelete2 = '<li>
                                    <a href="javascript:;" onclick="deleteData(' . $field->meetType_id . ')" class="tooltip-error" data-rel="tooltip" title="' . $this->lang->line('meettype_delete') . '">
                                        <span class="red">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
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

            // $row[] = $chkBox;
            $row[] = $field->meetType_id;
            $row[] = $field->meetType_name;
            $row[] = $btn;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->meet->count_new($cond),
            "recordsFiltered" => $this->meet->count_filtered_new($cond),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }

    function save()
    {
        $update = null;
        $insert = null;
        $state = null;
        $meetingTypeId = $this->input->post('meetingTypeId');
        $meetingTypeName = $this->input->post('meetingTypeName');
        $data = array(
            'meetType_name' => $meetingTypeName,
        );
        $cond = array(
            'meetType_id' => $meetingTypeId
        );
        if ($meetingTypeId) {
            $state = "Update";
            $update = $this->meet->updateMeetType($data, $cond);
            $msg = $this->lang->line('meettype_success_edit');
        } else {
            $state = "Create";
            $insert = $this->meet->insertMeetType($data);
            $msg = $this->lang->line('meettype_success_create');
        }

        if ($insert || $update) {
            $res = array(
                'is_success' => true,
                'message' => $msg,
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

    public function getOne()
    {
        $meetTypeId = $this->input->post('id');
        $data = $this->meet->getOne($meetTypeId);
        echo json_encode($data);
    }

    public function deleteData()
    {
        $meetTypeId =  $this->uri->segment(3);
        if ($this->meet->deleteData($meetTypeId)) {
            $res = array(
                'is_success' => true,
                'message' => $this->lang->line('meettype_success_delete'),
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
}
