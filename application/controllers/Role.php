<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Role extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $session_data = $this->session->userdata('logged_in');
        if (empty($session_data)) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('settings_model', 'setting');
        $this->system = $this->setting->getSystemSettings();
        $this->load->model('users_model', 'users');
        $this->load->model('role_model', 'role');
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
            'title' => $this->lang->line('role_title'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'menuakses' => $this->getmenulist(),
            'system' => $this->system
        );
        $this->template->load('default', 'role/index', $data);
    }

    function getmenulist()
    {
        $this->load->model('menu_model', 'menu_model');
        $menu = array();
        $menu_top = $this->menu_model->getmenujson();
        return $menu_top;
    }

    function cekpohon()
    {
        $id = $this->input->post('id');
        $this->load->model('menu_model', 'menu');
        $menu = array();
        $pohon = $this->menu->cektreeup($id);
        //echo json_encode($pohon);exit;
        $x = $pohon['menu_parent'];
        //$menu[]=$pohon;

        while ($x > 0) {
            $coba = $this->menu->cektreeup($x);
            $menu[] = $coba;
            $x = $coba['menu_parent'];
        }
        //print_r($menu);exit;
        echo  json_encode($menu);
    }


    function save()
    {
        $update = null;
        $insert = null;
        $state = null;
        $roleId = $this->input->post('role_id');
        $roleCode = $this->input->post('role_code');
        $roleName = $this->input->post('role_name');
        $roleAllowMenu = $this->input->post('role_allow_menu');

        $data = array(
            'role_code' => $roleCode,
            'role_name' => $roleName,
            'role_allow_menu' => $roleAllowMenu
        );
        $cond = array(
            'role_id' => $roleId
        );
        $data['role_created_date'] = date("Y-m-d H:i:s");
        $data['role_created_by'] = $this->session->userdata('logged_in')['role_id'];
        $data['role_status'] = 1;
        if($roleId){
            $state = "Update";
            $update = $this->role->updatetRole($data, $cond);
            $msg = $this->lang->line('role_success_edit');
        }else {
            $state = "Create";
            $insert = $this->role->insertRole($data);
            $msg = $this->lang->line('role_success_create');
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

    public function getList(){
        $cond = array(
            'role_status !=' => null
        );
        $list = $this->role->getList($cond);
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
            $btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('user/view/' . $field->role_id . '/' . $field->role_name) . '" title="' . $this->lang->line('role_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
            $btnView2 = '<li>
                                    <a href="' . base_url('user/view/' . $field->role_id . '/' . $field->role_name) . '"  class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('role_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';

            $btnView = "";
            $btnView2 = "";
            $btnEdit = '<a class="green" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="editData('. $field->role_id .')" title="'.$this->lang->line('role_edit').'">
                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                        </a>';
            $btnEdit2 = '<li>
                                    <a  href="javascript:;" onclick="editData(' . $field->role_id . ')"  class="tooltip-success" data-rel="tooltip" title="'.$this->lang->line('role_edit').'">
                                        <span class="green">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
            if ($field->role_status == 1) {
                $label = 'success';
                $text = 'Aktif';
            }
            if ($field->role_status == 2) {
                $label = 'warning';
                $text = 'Menunngu Validasi';
            }
            if ($field->role_status == 4) {
                $label = 'danger';
                $text = 'Rejected';
            }
            if ($field->role_status == 0) {
                $label = 'danger';
                $text = 'Non Aktif';
            }

            $btnDelete = '<a class="red" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="deleteData(' . $field->role_id . ')" title="'.$this->lang->line('role_delete').'">
                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                        </a>';
            $btnDelete2 = '<li>
                                    <a href="javascript:;" onclick="deleteData(' . $field->role_id . ')" class="tooltip-error" data-rel="tooltip" title="'.$this->lang->line('role_delete').'">
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

            // $content = strlen($field->user_desc) > 50 ? substr($field->user_desc, 0, 50) . "..." : $field->user_desc;
            $status = '<span class="label label-sm label-' . $label . '">' . $text . '</span>';
          
            // $row[] = $chkBox;
            $row[] = $field->role_id;
            $row[] = $field->role_code;
            $row[] = $field->role_name;
            $row[] = $btn;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->role->count_new($cond),
            "recordsFiltered" => $this->role->count_filtered_new($cond),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }

    public function getOne(){
        $roleId = $this->input->post('id');
        $data = $this->role->getOne($roleId);
        echo json_encode($data);
    }

    public function deleteData(){
        $roleId =  $this->uri->segment(3);
        if($this->role->deleteData($roleId)){
            $res = array(
                'is_success' => true,
                'message' => $this->lang->line('role_success_delete'),
            );
        }else{
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
