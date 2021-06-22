<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Announcement extends CI_Controller
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
        $this->load->model('announcement_model', 'announcement');
        $this->load->model('settings_model', 'setting');
        $this->system = $this->setting->getSystemSettings();
        $this->sessionUserDetail = $this->users->sessionUserDetail();
        $this->menu_body     = $this->Menu_model->getmenu($session_data['user_id'], $session_data['username']);
        // Menu Access announcement
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
            'title' => $this->lang->line('announ_title'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'menu_allow' => $this->data['menu_allow'],
            'user_allow_menu' => $this->data['user_allow_menu'],
            'system' => $this->system
        );
        $this->template->load('default', 'announcement/index', $data);
    }

    public function create()
    {
        $this->load->model('filter_model', 'filter');
        $dataSchool = $this->filter->getSchools(1);
        $data = array(
            'title' => $this->lang->line('announ_create'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'menu_allow' => $this->data['menu_allow'],
            'user_allow_menu' => $this->data['user_allow_menu'],
            'system' => $this->system,
            'schools' => $dataSchool
        );
        if ((!in_array($this->data['menu_allow'] . '_add', $this->data['user_allow_menu']))) {
            $this->template->load('default', '403', $data);
        } else {
            $this->template->load('default', 'announcement/create', $data);
        }
    }

    public function view()
    {
        if ((in_array($this->data['menu_allow'] . '_view', $this->data['user_allow_menu']))) {
            $announId = $this->uri->segment(3);
            // $announNumber = str_replace('-', ' ', $this->uri->segment(4));
            $dataAnnoun = $this->announcement->getOneAnnoun($announId);
            $announAttachment = $this->announcement->getOneAnnounAttachment($announId);
            if ($dataAnnoun && (($this->sessionUserDetail['role_id'] != 1) && ($dataAnnoun[0]['school_id'] == '' || $dataAnnoun[0]['school_id'] == null || $this->sessionUserDetail['school_id'] == $dataAnnoun[0]['school_id']))) {
                // print_r($data);die;

                $data = array(
                    'title' => $dataAnnoun[0]['announ_title'],
                    'menu_body' => $this->menu_body,
                    'usDetail' => $this->sessionUserDetail,
                    'announ' => $dataAnnoun,
                    'announAttachment' => $announAttachment,
                    'menu_allow' => $this->data['menu_allow'],
                    'user_allow_menu' => $this->data['user_allow_menu'],
                    'system' => $this->system
                );
                $this->template->load('default', 'announcement/view', $data);
            } else if ($dataAnnoun && (($this->sessionUserDetail['role_id'] == 1))) {
                $data = array(
                    'title' => $dataAnnoun[0]['announ_title'],
                    'menu_body' => $this->menu_body,
                    'usDetail' => $this->sessionUserDetail,
                    'announ' => $dataAnnoun,
                    'announAttachment' => $announAttachment,
                    'menu_allow' => $this->data['menu_allow'],
                    'user_allow_menu' => $this->data['user_allow_menu'],
                    'system' => $this->system
                );
                $this->template->load('default', 'announcement/view', $data);
            } else {
                $data = array(
                    'title' => $this->lang->line('text_404'),
                    'menu_body' => $this->menu_body,
                    'usDetail' => $this->sessionUserDetail,
                    'menu_allow' => $this->data['menu_allow'],
                    'user_allow_menu' => $this->data['user_allow_menu'],
                    'system' => $this->system
                );
                $this->template->load('default', '404', $data);
            }
        } else {
            $data = array(
                'title' => $this->lang->line('text_403'),
                'menu_body' => $this->menu_body,
                'usDetail' => $this->sessionUserDetail,
                'menu_allow' => $this->data['menu_allow'],
                'user_allow_menu' => $this->data['user_allow_menu'],
                'system' => $this->system
            );
            $this->template->load('default', '403', $data);
        }
    }


    public function edit()
    {
        $this->load->model('filter_model', 'filter');
        $dataSchool = $this->filter->getSchools(1);
        if ((in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
            $announId = $this->uri->segment(3);
            // $announNumber = str_replace('-', ' ', $this->uri->segment(4));
            $dataAnnoun = $this->announcement->getOneAnnoun($announId);
            $announAttachment = $this->announcement->getOneAnnounAttachment($announId);
            if ($dataAnnoun && (($this->sessionUserDetail['role_id'] != 1) && ($this->sessionUserDetail['school_id'] == $dataAnnoun[0]['school_id']))) {
                // print_r($data);die;

                $data = array(
                    'title' => $dataAnnoun[0]['announ_title'],
                    'menu_body' => $this->menu_body,
                    'usDetail' => $this->sessionUserDetail,
                    'announ' => $dataAnnoun,
                    'announAttachment' => $announAttachment,
                    'menu_allow' => $this->data['menu_allow'],
                    'user_allow_menu' => $this->data['user_allow_menu'],
                    'system' => $this->system,
                    'schools' => $dataSchool
                );
                $this->template->load('default', 'announcement/edit', $data);
            } else if ($dataAnnoun && (($this->sessionUserDetail['role_id'] == 1))) {
                $data = array(
                    'title' => $dataAnnoun[0]['announ_title'],
                    'menu_body' => $this->menu_body,
                    'usDetail' => $this->sessionUserDetail,
                    'announ' => $dataAnnoun,
                    'announAttachment' => $announAttachment,
                    'menu_allow' => $this->data['menu_allow'],
                    'user_allow_menu' => $this->data['user_allow_menu'],
                    'system' => $this->system,
                    'schools' => $dataSchool
                );
                $this->template->load('default', 'announcement/edit', $data);
            } else {
                $data = array(
                    'title' => $this->lang->line('text_404'),
                    'menu_body' => $this->menu_body,
                    'usDetail' => $this->sessionUserDetail,
                    'menu_allow' => $this->data['menu_allow'],
                    'user_allow_menu' => $this->data['user_allow_menu'],
                    'system' => $this->system,
                    'schools' => $dataSchool
                );
                $this->template->load('default', '404', $data);
            }
        } else {
            $data = array(
                'title' => $this->lang->line('text_403'),
                'menu_body' => $this->menu_body,
                'usDetail' => $this->sessionUserDetail,
                'menu_allow' => $this->data['menu_allow'],
                'user_allow_menu' => $this->data['user_allow_menu'],
                'system' => $this->system,
                'schools' => $dataSchool
            );
            $this->template->load('default', '403', $data);
        }
    }

    public function getList()
    {
        $cond = array(
            'announ_status !=' => 0
        );
        $list = $this->announcement->getList($cond);
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
            $btnView = "";
            $btnView2 = "";
            if ((in_array($this->data['menu_allow'] . '_view', $this->data['user_allow_menu']))) {
                $btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('announcement/view/' . $field->announ_id . '/' . str_replace(' ', '-', $field->announ_number)) . '" title="' . $this->lang->line('announ_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
                $btnView2 = '<li>
                                    <a href="' . base_url('announcement/view/' . $field->announ_id . '/' . str_replace(' ', '-', $field->announ_number)) . '"  class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('announ_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
            }


            if ((in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
                if ((($this->session->userdata('logged_in')['role_id'] == 1) || ($field->announ_created_by == $this->sessionUserDetail['user_id'])) || (($this->sessionUserDetail['role_id']) == 3) && ($field->school_id == $this->sessionUserDetail['school_id'])) {
                    $btnEdit = '<a class="green" data-rel="tooltip" data-placement="bottom" href="' . base_url('announcement/edit/' . $field->announ_id . '/' . str_replace(' ', '-', $field->announ_number)) . '" title="' . $this->lang->line('announ_edit') . '">
                            <i class="ace-icon fa fa-pencil bigger-130"></i>
                        </a>';
                    $btnEdit2 = '<li>
                                    <a  href="' . base_url('announcement/edit/' . $field->announ_id . '/' . str_replace(' ', '-', $field->announ_number)) . '"  class="tooltip-success" data-rel="tooltip" title="' . $this->lang->line('announ_edit') . '">
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
            if ((in_array($this->data['menu_allow'] . '_delete', $this->data['user_allow_menu']))) {
                $btnDelete = '<a class="red" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="deleteData(' . $field->announ_id . ')" title="' . $this->lang->line('announ_delete') . '">
                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                        </a>';
                $btnDelete2 = '<li>
                                    <a href="javascript:;" onclick="deleteData(' . $field->announ_id . ')" class="tooltip-error" data-rel="tooltip" title="' . $this->lang->line('announ_delete') . '">
                                        <span class="red">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
            }
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
            // $row[] = $field->announ_id;
            $content = strlen($field->announ_content) > 50 ? substr($field->announ_content, 0, 50) . "..." : $field->announ_content;
            $row[] = $field->school_name ? $field->school_name : '-';
            $row[] = P($field->announ_number);
            $row[] = P($field->announ_subject);
            $row[] = P(date('d-m-Y', strtotime($field->announ_date)));
            $row[] = P($field->announ_title);
            $row[] = $content;
            $row[] = P(date('d-m-Y H:i:s', strtotime($field->announ_created_date)));
            $row[] = $field->user_username;
            $row[] = $btn;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->announcement->count_new($cond),
            "recordsFiltered" => $this->announcement->count_filtered_new($cond),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }

    function save()
    {
        $this->db->trans_begin();
        $update = null;
        $insert = null;
        $state = null;
        $announcementId = $this->input->post('announ_id');
        $announcementNumber = $this->input->post('announ_number');
        $announcementDate = date('Y-m-d', strtotime(str_replace('/', '-', $this->input->post('announ_date'))));
        $announcementSubject = $this->input->post('announ_subject');
        $announcementTitle = $this->input->post('announ_title');
        $announcementContent = $this->input->post('announ_content');
        $schoolId = DecryptString($this->input->post('school_id')) ? DecryptString($this->input->post('school_id')) : $this->sessionUserDetail['school_id'];
        $data = array(
            'announ_title' => $announcementTitle,
            'announ_number' => $announcementNumber,
            'announ_subject' => $announcementSubject,
            'announ_date' => $announcementDate,
            'announ_content' => $announcementContent,
            'announ_status' => 1,
        );
        $cond = array(
            'announ_id' => $announcementId
        );
        if ($announcementId) {
            $dataAnnoun = $this->announcement->getSchoolAnnoun($announcementId);
            $state = "Update";
            $data['announ_last_update_by'] = $this->sessionUserDetail['user_id'];
            $data['announ_last_update'] = date('Y-m-d H:i:s');
            $update = $this->announcement->updatetAnnouncement($data, $cond);
            $insert_id = $announcementId;
            $msg = $this->lang->line('announ_success_edit');
        } else {
            $state = "Create";
            $data['school_id'] = $schoolId;
            $data['announ_created_by'] = $this->sessionUserDetail['user_id'];
            $data['announ_created_date'] = date('Y-m-d H:i:s');
            $insert = $this->announcement->insertAnnouncement($data);
            $insert_id = $this->db->insert_id();
            $msg = $this->lang->line('announ_success_create');
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
                    if (!is_dir('assets/uploads/announcement')) {
                        mkdir('assets/uploads/announcement/', 0777, true);
                    }
                    if (!is_dir('assets/uploads/announcement/schoolId_' . $schoolId)) {
                        mkdir('assets/uploads/announcement/schoolId_' . $schoolId, 0777, true);
                    }
                    $config['upload_path'] = './assets/uploads/announcement/schoolId_' . $schoolId;
                    $config['allowed_types'] = 'jpg|jpeg|png|pdf|doc|docx|mp4|mpeg4';
                    $config['max_size'] = '5000'; // max_size in kb
                    $config['overwrite'] = FALSE;
                    $config['file_name'] = $schoolId . '_' . $announcementNumber . '_' . time();

                    //Load upload library
                    $this->load->library('upload', $config);

                    // File upload
                    if ($this->upload->do_upload('file')) {
                        // Get data about the file
                        $uploadData = $this->upload->data();
                        $filename = $uploadData['file_name'];
                        $dataUpload[$i]['announ_id'] = $insert_id;
                        $dataUpload[$i]['aa_name'] = $filename;
                        $dataUpload[$i]['aa_dir'] = base_url('assets/uploads/announcement/schoolId_' . $schoolId . '/') . $filename;
                        // $dataUpload[$i]['aa_created_date'] = date('Y-m-d H:i:s');
                    }
                }
            }
            $insertAttachment = $this->announcement->insertAttachment($dataUpload);
            // if ($insertAttachment) {

            //     $res = array(
            //         'is_success' => true,
            //         'message' => $msg,
            //     );
            // } else {
            //     $err = $this->db->error();
            //     $msg = $err["code"] . "-" . $err["message"];
            //     $res = array(
            //         'is_success' => false,
            //         'message' =>  $msg
            //     );
            // }
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $err = $this->db->error();
                $res = array(
                    'is_success' => false,
                    'message' =>  $err,
                );
            } else {
                $this->db->trans_commit();
                $res = array(
                    'is_success' => true,
                    'message' => $msg,
                );
                $this->load->model('users_model', 'user');
                $cond = array(
                    'school_id' => $schoolId
                );
                $allUser = $this->user->getAllUserWithFilter($cond);

                $this->load->helper('Mail_helper');
                $url = site_url('announcement/view/' . $insert_id . '/' . str_replace(' ', '-', $announcementNumber));
                foreach ($allUser as $user) {
                    $dataTemplate = array(
                        'header' => "Notification",
                        'text' => "Dear " . $user['user_username'] . ",<br/>You have New Announecement <b>$announcementTitle</b>.",
                        'btnText' => null,
                        'btnLink' => null
                    );
                    $message = $this->load->view('template/mail', $dataTemplate, TRUE);
                    sendMail($user['user_email'], 'Announcement', $message, null, 'KMSchool');
                    $dataNotif = array(
                        'user_id' => $user['user_id'],
                        'notif_subj' => 'uploaded',
                        'notif_msg' =>  "You Have A New Announcement.",
                        'notif_url' =>   $url,
                        'notif_status' => 0,
                        'notif_date' => date('Y-m-d H:i:s')
                    );
                    $this->db->insert('kms_notification', $dataNotif);
                }
            }
        }
        echo json_encode($res);
    }

    public function getOne()
    {
        $announcementId = $this->input->post('id');
        $data = $this->announcement->getOne($announcementId);
        echo json_encode($data);
    }

    public function deleteData()
    {
        $announcementId =  $this->uri->segment(3);
        $cond = array(
            'announ_id' => $announcementId
        );
        $data = array(
            'announ_status' => 0
        );
        if ($this->announcement->updatetAnnouncement($data, $cond)) {
            $res = array(
                'is_success' => true,
                'message' => $this->lang->line('announ_success_delete'),
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

    public function deleteAttach()
    {
        $id = $this->input->post('fileId');
        $data  = $this->announcement->getOneAnnounAttachmentByAttacId($id);
        $schoolId = $data[0]['school_id'] ? $data[0]['school_id'] : 0;
        if (unlink('assets/uploads/announcement/schoolId_' . $schoolId . '/' . $data[0]['aa_name'])) {
            $delete = $this->announcement->deleteAttach($id);
            if ($delete) {
                $res = array(
                    'is_success' => true,
                    'message' => $this->lang->line('document_success_delete_file'),
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
        echo json_encode($res);
    }
}
