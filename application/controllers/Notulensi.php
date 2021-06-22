<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Notulensi extends CI_Controller
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
        $this->load->model('notulensi_model', 'notulensi');
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
        $this->load->model('filter_model', 'filter');
        $data = array(
            'title' => $this->lang->line('notulensi_title'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'menu_allow' => $this->data['menu_allow'],
            'user_allow_menu' => $this->data['user_allow_menu'],
            'system' => $this->system,
            'filterSchools' => $this->filter->getSchools(1),
            'filterMeetType' => $this->filter->getMeetType(),
        );
        $this->template->load('default', 'notulensi/index', $data);
    }

    public function create()
    {
        $this->load->model('filter_model', 'filter');
        $dataNoteType = $this->notulensi->getType();
        $dataSchool = $this->filter->getSchools(1);
        $data = array(
            'title' => $this->lang->line('notulensi_create'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'menu_allow' => $this->data['menu_allow'],
            'user_allow_menu' => $this->data['user_allow_menu'],
            'system' => $this->system,
            'noteType' => $dataNoteType,
            'schools' => $dataSchool
        );
        if ((!in_array($this->data['menu_allow'] . '_add', $this->data['user_allow_menu']))) {
            $this->template->load('default', '403', $data);
        } else {
            $this->template->load('default', 'notulensi/create', $data);
        }
    }

    public function save(){
        $insert = null;
        $update = null;
        $notulensiId = $this->input->post('notulensi_id');
        if (!$notulensiId && (!in_array($this->data['menu_allow'] . '_add', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('notulensi_accsess_warning'),
            );
            echo json_encode($res);
            exit;
        }
        if ($notulensiId && (!in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('notulensi_accsess_warning'),
            );
            echo json_encode($res);
            exit;
        }
        $noteType = $this->input->post('notulensi_type');
        $noteCode = 'RPT-' . date('ymdhis');
        $noteAgenda = $this->input->post('notulensi_agenda');
        $noteLeader = $this->input->post('notulensi_leader');
        $notePlace = $this->input->post('notulensi_place');
        $noteDate = $this->input->post('notulensi_date');
        $noteStart = $this->input->post('notulensi_start');
        $noteEnd = $this->input->post('notulensi_end');
        $noteContent = $this->input->post('notulensi_content');
        $schoolId = DecryptString($this->input->post('school_id')) ? DecryptString($this->input->post('school_id')) : $this->sessionUserDetail['school_id'];
        // $isPublic = $this->input->post('is_public') ? 1 : 0;
        $data = array(
            'meetType_id' => $noteType,
            'school_id' => $schoolId,
            // 'is_public' => $isPublic,
            'notulensi_code' => $noteCode,
            'user_id' => $this->session->userdata('logged_in')['user_id'],
            'notulensi_agenda' =>  $noteAgenda,
            'notulensi_leader' =>  $noteLeader,
            'notulensi_place' =>  $notePlace,
            'notulensi_date' => date("Y-m-d", strtotime($noteDate)),
            'notulensi_start' => $noteStart,
            'notulensi_end' =>  $noteEnd,
            'notulensi_content' => $noteContent,
            'notulensi_status' => 2,
            'notulensi_created_date' => date("Y-m-d H:i:s"),
        );
        if($notulensiId){
            $update = $this->notulensi->updateNotulensi($data, $notulensiId);
        } else {
            $insert = $this->notulensi->insertNotulensi($data);
        }
        if($insert || $update){
            if($insert){
                $state = "Menambahkan";
                $insert_id = $this->db->insert_id();
                $msg = $this->lang->line('notulensi_success_create');
            }
            if ($update) {
                $insert_id = $notulensiId;
                $state = "Mengedit";
                $msg = $this->lang->line('notulensi_success_edit');
            }
            
            $file = $_FILES;
            if ($file) {
                $countfiles = count($_FILES['files']['name']);
                // Looping all files
                for ($i = 0; $i < $countfiles; $i++) {

                    if (!empty($_FILES['files']['name'][$i])) {

                        // Define new $_FILES array - $_FILES['file']
                        $_FILES['file']['name'] = $_FILES['files']['name'][$i];
                        $_FILES['file']['type'] = $_FILES['files']['type'][$i];
                        $_FILES['file']['tmp_name'] = $_FILES['files']['tmp_name'][$i];
                        $_FILES['file']['error'] = $_FILES['files']['error'][$i];
                        $_FILES['file']['size'] = $_FILES['files']['size'][$i];

                        // Set preference
                        $config['upload_path'] = './assets/uploads/notulensi';
                        $config['allowed_types'] = 'jpg|jpeg|png|gif';
                        $config['max_size'] = '5000'; // max_size in kb
                        $config['overwrite'] = FALSE;
                        $config['file_name'] = $insert_id.'_'. $noteCode.'_'.$i;

                        //Load upload library
                        $this->load->library('upload', $config);

                        // File upload
                        if ($this->upload->do_upload('file')) {
                            // Get data about the file
                            $uploadData = $this->upload->data();
                            $filename = $uploadData['file_name'];
                            $dataUpload[$i]['notulensi_id'] = $insert_id;
                            $dataUpload[$i]['na_name'] = $filename;
                            $dataUpload[$i]['na_dir'] = base_url('assets/uploads/notulensi/') . $filename;
                            $dataUpload[$i]['na_created_date'] = date('Y-m-d H:i:s'); 
                            // Initialize array
                        }
                    }
                }
                $insertAttachment = $this->notulensi->inserAttachment($dataUpload);
                if ($insertAttachment){
                   
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
            } else {
                $res = array(
                    'is_success' => true,
                    'message' => $msg,
                );
            }
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

    public function getList(){
        
        $cond = array(
            'notulensi_status !=' => 0
        );
        $filter_school = $this->input->post('filter_school');
        $filter_meetType = $this->input->post('filter_meetType');
        $filter_status = $this->input->post('filter_status');
        if($filter_school != 0 || $filter_school != '0'){
            $cond['ks.school_id'] = DecryptString($filter_school);
        }
        if ($filter_meetType != 0 || $filter_meetType != '0') {
            $cond['kmt.meetType_id'] = DecryptString($filter_meetType);
        }
        if ($filter_status != 0 || $filter_status != '0') {
            $cond['notulensi_status'] = DecryptString($filter_status);
        }
        $list = $this->notulensi->getList($cond);
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
            $btnEdit = "";
            $btnEdit2 = "";
            $btnView = "";
            $btnView2 = "";
            $btnDelete = "";
            $btnDelete2= "";

            if ((in_array($this->data['menu_allow'] . '_validasi', $this->data['user_allow_menu']))) {

                $btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('notulensi/view/' . $field->notulensi_id . '/' . $field->notulensi_code) . '" title="' . $this->lang->line('notulensi_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
                $btnView2 = '<li>
                                    <a href="' . base_url('notulensi/view/' . $field->notulensi_id . '/' . $field->notulensi_code) . '" class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('notulensi_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
            } else if ((in_array($this->data['menu_allow'] . '_view', $this->data['user_allow_menu'])) && (in_array($field->notulensi_status, array(1,2,3)))) {
                $btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('notulensi/view/' . $field->notulensi_id . '/' . $field->notulensi_code) . '" title="' . $this->lang->line('notulensi_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
                $btnView2 = '<li>
                                    <a href="' . base_url('notulensi/view/' . $field->notulensi_id . '/' . $field->notulensi_code) . '" class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('notulensi_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
            }

            if((in_array($field->notulensi_status, array(2))) && (in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))){
                if((($this->session->userdata('logged_in')['role_id'] == 1) || $field->user_id == $this->session->userdata('logged_in')['user_id'])){
                    $btnEdit = '<a class="green" data-rel="tooltip" data-placement="bottom" href="' . base_url('notulensi/edit/' . $field->notulensi_id . '/' . $field->notulensi_code) . '" title="' . $this->lang->line('notulensi_edit') . '">
                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                        </a>';
                    $btnEdit2 = '<li>
                                    <a  href="' . base_url('notulensi/edit/' . $field->notulensi_id . '/' . $field->notulensi_code) . '" class="tooltip-success" data-rel="tooltip" title="' . $this->lang->line('notulensi_edit') . '">
                                        <span class="green">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
                } else if (($this->session->userdata('logged_in')['role_id'] == 3) && $field->school_id == $this->session->userdata('logged_in')['school_id']) {
                    $btnEdit = '<a class="green" data-rel="tooltip" data-placement="bottom" href="' . base_url('notulensi/edit/' . $field->notulensi_id . '/' . $field->notulensi_code) . '" title="' . $this->lang->line('notulensi_edit') . '">
                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                        </a>';
                    $btnEdit2 = '<li>
                                    <a  href="' . base_url('notulensi/edit/' . $field->notulensi_id . '/' . $field->notulensi_code) . '" class="tooltip-success" data-rel="tooltip" title="' . $this->lang->line('notulensi_edit') . '">
                                        <span class="green">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
                } else {
                    $btnEdit = "";
                    $btnEdit2 = "";
                }
            }
            if((in_array($this->data['menu_allow'] . '_delete', $this->data['user_allow_menu']))){
                $btnDelete = '<a class="red" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="approval(0,' . $field->notulensi_id . ')" title="'. $this->lang->line('notulensi_delete').'">
                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                        </a>';
                $btnDelete2 = '<li>
                                    <a href="javascript:;" onclick="approval(0,' . $field->notulensi_id . ')" class="tooltip-error" data-rel="tooltip" title="' . $this->lang->line('notulensi_delete') . '">
                                        <span class="red">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
            }
            $btn = '<div class="hidden-sm hidden-xs action-buttons">
                    '.$btnView.$btnEdit.$btnDelete. '
                    </div>
                    <div class="hidden-md hidden-lg">
                        <div class="inline pos-rel">
                            <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                            </button>

                            <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                             ' . $btnView2 . $btnEdit2 . $btnDelete2 . '   
                             </ul>
                        </div>
                    </div>';
            $chkBox = '<input type="checkbox" class="ace" /><span class="lbl"></span>';
            if($field->notulensi_status==1) {
                $label = 'success';
                $text = $this->lang->line('notulensi_validated_status');
            }
            if($field->notulensi_status==2) {
                $label = 'warning';
                $text =  $this->lang->line('notulensi_waiting_valid');
            }
            if($field->notulensi_status==3) {
                $label = 'danger';
                $text =  $this->lang->line('notulensi_invalidated_status');
            }
            if ($field->notulensi_status == 0) {
                $label = 'danger';
                $text = $this->lang->line('notulensi_deleted_status');
            }
            $content = strlen($field->notulensi_content) > 50 ? substr($field->notulensi_content, 0, 50) . "..." : $field->notulensi_content;
            $status = '<span class="label label-sm label-'. $label.'">' . $text.'</span>';
            $notulensiDate = date("d-m-Y", strtotime($field->notulensi_date));
            // $row[] = $chkBox;
            $row[] = P($field->school_name);
            $row[] = P($field->user_username);
            $row[] = P($field->notulensi_code);
            $row[] = P($field->notulensi_agenda);
            $row[] = ($content);
            $row[] = $notulensiDate;
            $row[] = P($field->meetType_name);
            $row[] = $status;
            $row[] = $btn;
            $data[] = $row;
        }


        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->notulensi->count_new($cond),
            "recordsFiltered" => $this->notulensi->count_filtered_new($cond),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }

    public function view(){
        if((in_array($this->data['menu_allow'] . '_view', $this->data['user_allow_menu']))){
            $notulensiId = $this->uri->segment(3);
            $notulensiCode = $this->uri->segment(4);

            $dataNotulensi = $this->notulensi->getOneNotulensi($notulensiId, $notulensiCode);
            $noteAttachment = $this->notulensi->getOneNotulensiAttachment($notulensiId);

            if ($dataNotulensi) {
                // print_r($data);die;

                $data = array(
                    'title' => $dataNotulensi[0]['notulensi_code'],
                    'menu_body' => $this->menu_body,
                    'usDetail' => $this->sessionUserDetail,
                    'noteData' => $dataNotulensi,
                    'noteAttachment' => $noteAttachment,
                    'menu_allow' => $this->data['menu_allow'],
                    'user_allow_menu' => $this->data['user_allow_menu'],
                    'system' => $this->system
                );
                $this->template->load('default', 'notulensi/view', $data);
            } else {
                $data = array(
                    'title' => 'Not Found',
                    'menu_body' => $this->menu_body,
                    'usDetail' => $this->sessionUserDetail,
                    'menu_allow' => $this->data['menu_allow'],
                    'user_allow_menu' => $this->data['user_allow_menu'],
                    'system' => $this->system
                );
                $this->template->load('default', '404', $data);
            }
        }else {
            $data = array(
                'title' => 'Not Allowed',
                'menu_body' => $this->menu_body,
                'usDetail' => $this->sessionUserDetail,
                'menu_allow' => $this->data['menu_allow'],
                'user_allow_menu' => $this->data['user_allow_menu'],
                'system' => $this->system
            );
            $this->template->load('default', '403', $data);
        }
        
    }

    public function approval(){
        $status = $this->input->post('status');
        if (($status != 0) && (!in_array($this->data['menu_allow'] . '_validasi', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('notulensi_accsess_warning'),
            );
            echo json_encode($res);
            exit;
        }
        if (($status == 0) && (!in_array($this->data['menu_allow'] . '_delete', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('notulensi_accsess_warning'),
            );
            echo json_encode($res);
            exit;
        }
        $notulensiId = $this->uri->segment(3);
        $data = array(
            'notulensi_status' => $status,
            'notulensi_last_update' => date('Y-m-d H:i:s')
        );
        $approve = $this->notulensi->approval($data, $notulensiId);
        if($status==1){
            $approval = "Di Validasi";
            $msg = $this->lang->line('notulensi_validated');
        }
        if ($status == 3) {
            $approval = "Tidak Valid";
            $msg = $this->lang->line('notulensi_invalidated');
        }
        if ($status == 0) {
            $msg = $this->lang->line('notulensi_deleted');
        }
        if($approve){
            $res = array(
                'is_success' => true,
                'message' => $msg ,
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

    public function edit(){
        $this->load->model('filter_model', 'filter');
        $notulensiId = $this->uri->segment(3);
        $notulensiCode = $this->uri->segment(4);
        $dataNoteType = $this->notulensi->getType();
        $dataNotulensi = $this->notulensi->getOneNotulensi($notulensiId, $notulensiCode);
        $noteAttachment = $this->notulensi->getOneNotulensiAttachment($notulensiId);
        $dataSchool = $this->filter->getSchools(1);
        $data = array(
            'title' => $this->lang->line('notulensi_edit'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'noteData' => $dataNotulensi,
            'noteAttachment' => $noteAttachment,
            'system' => $this->system,
            'noteType' => $dataNoteType,
            'schools' => $dataSchool
        );
        if ((!in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
            $this->template->load('default', '403', $data);
        } else {
            if ($dataNotulensi) {
                // print_r($data);die;
                $this->template->load('default', 'notulensi/edit', $data);
            } else {
                $this->template->load('default', '404', $data);
            }
        }
    }

    public function deleteImg() {
        $id = $this->input->post('imgId');
        $delete = $this->notulensi->deleteImg($id);
        if($delete){
            $res = array(
                'is_success' => true,
                'message' =>  $this->lang->line('notulensi_success_delete_img'),
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
