<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Forum extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $session_data = $this->session->userdata('logged_in');
        if (empty($session_data)) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('forum_model', 'forum');
        $this->load->model('users_model', 'users');
        $this->load->model('settings_model', 'setting');
        $this->system = $this->setting->getSystemSettings();
        $this->sessionUserDetail = $this->users->sessionUserDetail();
        $this->load->library('pagination');
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
            'title' => $this->lang->line('forum_title'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'menu_allow' => $this->data['menu_allow'],
            'user_allow_menu' => $this->data['user_allow_menu'],
            'system' => $this->system
        );
        $this->template->load('default', 'forum/index', $data);
    }

    public function create()
    {
        $data = array(
            'title' => $this->lang->line('forum_create'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'system' => $this->system
        );
        if ((!in_array($this->data['menu_allow'] . '_add', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('warning_access'),
            );
            $this->template->load('default', '403', $data);
        } else {
            $this->template->load('default', 'forum/create', $data);
        }
    }

    public function save()
    {
        $insert = null;
        $update = null;
        $state = null;
        $forumId = $this->input->post('post_id');
        if (!$forumId && (!in_array($this->data['menu_allow'] . '_add', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('warning_access'),
            );
            echo json_encode($res);
            exit;
        }
        if ($forumId && (!in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('warning_access'),
            );
            echo json_encode($res);
            exit;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('post_title', 'Judul Forum', 'required');
        $this->form_validation->set_rules('post_category', 'Kategori Forum', 'required');
        $this->form_validation->set_rules('post_content', 'Isi Forum', 'required');
        if ($this->form_validation->run() == FALSE) {
            $res =  array(
                'is_success' => false,
                'message' => validation_errors()
            );
        } else {
            $params = $this->input->post();
            // print_r($params['post_category']);die;
            if ($forumId) {
                $cond = array(
                    'forum_id' => $params['post_id']
                );
                $data = array(
                    'forum_title' => $params['post_title'],
                    'forum_slug' => url_title($params['post_title'], 'dash', true),
                    'forum_content' => $params['post_content'],
                    'forum_category' => str_replace(' ', '', trim($params['post_category'])),
                    'forum_last_update' => date('Y-m-d H:i:s'),
                    'forum_last_update_by' => $this->session->userdata('logged_in')['user_id'],

                );
                $update = $this->forum->update($cond, $data);
                $state = "Edit";
                $msg = $this->lang->line('forum_success_edit');
            } else {
                $insert = $this->forum->insert($params);
                $state = "Create";
                $forumId = $this->db->insert_id();
                $msg = $this->lang->line('forum_success_create');
            }

            if ($insert || $update) {
                $res =  array(
                    'is_success' => true,
                    'message' =>  $msg,
                    'forum_id' => $forumId,
                    'forum_slug' => url_title($params['post_title'], 'dash', true)
                );
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

    public function view()
    {
        $forumId = $this->uri->segment(3);
        $forumSlug = $this->uri->segment(4);
        $dataForum = $this->forum->getSingleForum($forumId, $forumSlug);
        $data = array(
            'title' => $dataForum[0]['forum_title'],
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'system' => $this->system
        );
        foreach ($dataForum as $row) {
            $dataForum = array(
                'forum_id' => $row['forum_id'],
                'forum_title' => $row['forum_title'],
                'forum_slug' => $row['forum_slug'],
                'forum_content' => $row['forum_content'],
                'forum_category' => $row['forum_category'],
                'user_img' => $row['ud_img_name'] ? $row['ud_img_name'] : 'avatar2.png',
                'username' => $row['user_username'],
                'school_name' => $row['school_name'],
                'forum_created' => $row['forum_created_date'],
                'forum_is_closed' => $row['forum_is_closed'],
                'role_name' => $row['role_name'],
                'menu_allow' => $this->data['menu_allow'],
                'user_allow_menu' => $this->data['user_allow_menu']
            );
        }
        $data['dataForum'] = $dataForum;
        // print_r($data);die;
        $this->template->load('default', 'forum/view', $data);
    }

    public function loadRecord($rowno = 0)
    {

        // Row per page
        $rowperpage = 6;

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }

        // All records count
        $allcount = $this->forum->getDataListCount();

        // Get records
        $users_record = $this->forum->getDataList($rowno, $rowperpage);

        // Pagination Configuration
        $config['base_url'] = base_url() . '/forum/loadRecord';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;

        $config['full_tag_open']    = '<div class="center"><ul class="pagination">';
        $config['full_tag_close']   = '</ul></div>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"';
        $config['cur_tag_close']    = '</li>';
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tag_close']  = '</li>';
        $config['prev_tag_open']    = '<li class="page-item">';
        $config['prev_tag_close']  = '</li>';
        $config['first_tag_open']   = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open']    = '<li class="page-item">';
        $config['last_tag_close']  = '</li>';

        // Initialize
        $this->pagination->initialize($config);

        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;

        echo json_encode($data);
    }

    public function saveReply()
    {
        $forumId = $this->input->post('forum_id');
        $forumSlug = $this->input->post('forum_slug');
        $replyContent = $this->input->post('replyContent');
        $dataForum = $this->forum->getSingleForum($forumId, $forumSlug);
        $insert = $this->forum->insertComment($forumId, $replyContent);
        if ($insert && $dataForum) {
            $res =  array(
                'is_success' => true,
                'message' => $this->lang->line('forum_success_reply'),
            );
            $owner = $dataForum[0]['user_username'];
            $responer = $this->session->userdata('logged_in')['user_username'];
            $forum_title = $dataForum[0]['forum_title'];
            if ($owner != $responer) {
                $this->load->helper('Mail_helper');
                $dataTemplate = array(
                    'header' => "Notification",
                    'text' => "Dear $owner,<br/><b> $responer </b> Has Replied your Forum <b>$forum_title</b>.",
                    'btnText' => null,
                    'btnLink' => null
                );
                $url = site_url("forum/view/$forumId/$forumSlug");
                $message = $this->load->view('template/mail', $dataTemplate, TRUE);
                sendMail($dataForum[0]['user_email'], 'Notification', $message, null, 'KMSchool');
                $dataNotif = array(
                    'user_id' => $owner,
                    'notif_subj' => 'replied',
                    'notif_msg' =>  "<b>$responer</b> Has Replied your Forum <b>$forum_title</b>.",
                    'notif_url' =>  $url,
                    'notif_status' => 0,
                    'notif_date' => date('Y-m-d H:i:s')
                );
                $this->db->insert('kms_notification', $dataNotif);
            }
        } else {
            $err = $this->db->error();
            $message = $err["code"] . "-" . $err["message"];
            $res =  array(
                'is_success' => false,
                'message' => $message,
            );
        }
        echo json_encode($res);
    }

    public function loadComment($rowno = 0)
    {
        // Row per page
        $rowperpage = 5;
        $forumId = $this->input->post('forumId');

        // Row position
        if ($rowno != 0) {
            $rowno = ($rowno - 1) * $rowperpage;
        }

        // All records count
        $allcount = $this->forum->getDataCommentCount($forumId);

        // Get records
        $users_record = $this->forum->getDataCommentList($rowno, $rowperpage, $forumId);

        // Pagination Configuration
        $config['base_url'] = base_url() . '/forum/loadComment';
        $config['use_page_numbers'] = TRUE;
        $config['total_rows'] = $allcount;
        $config['per_page'] = $rowperpage;

        $config['full_tag_open']    = '<div class="center"><ul class="pagination">';
        $config['full_tag_close']   = '</ul></div>';
        $config['num_tag_open']     = '<li class="page-item">';
        $config['num_tag_close']    = '</li>';
        $config['cur_tag_open']     = '<li class="page-item active"';
        $config['cur_tag_close']    = '</li>';
        $config['next_tag_open']    = '<li class="page-item">';
        $config['next_tag_close']  = '</li>';
        $config['prev_tag_open']    = '<li class="page-item">';
        $config['prev_tag_close']  = '</li>';
        $config['first_tag_open']   = '<li class="page-item">';
        $config['first_tag_close'] = '</li>';
        $config['last_tag_open']    = '<li class="page-item">';
        $config['last_tag_close']  = '</li>';

        // Initialize
        $this->pagination->initialize($config);

        // Initialize $data Array
        $data['pagination'] = $this->pagination->create_links();
        $data['result'] = $users_record;
        $data['row'] = $rowno;

        echo json_encode($data);
    }

    public function deleteComment()
    {
        $commentId =  $this->input->post('commentId');
        $delete = $this->forum->deleteComment($commentId);
        if ($delete) {
            $res =  array(
                'is_success' => true,
                'message' => $this->lang->line('forum_success_delete_reply'),
            );
        } else {
            $err = $this->db->error();
            $message = $err["code"] . "-" . $err["message"];
            $res =  array(
                'is_success' => false,
                'message' => $message,
            );
        }
        echo json_encode($res);
    }

    public function edit()
    {
        $data = array(
            'title' => $this->lang->line('forum_edit'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'system' => $this->system
        );
        if ((!in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('warning_access'),
            );
            $this->template->load('default', '403', $data);
        } else {
            $forumId = $this->uri->segment(3);
            $forumSlug = $this->uri->segment(4);
            $dataForum = $this->forum->getSingleForum($forumId, $forumSlug);
            foreach ($dataForum as $row) {
                $dataForum = array(
                    'forum_id'  => $row['forum_id'],
                    'user_id'  => $row['user_id'],
                    'forum_title' => $row['forum_title'],
                    'forum_content' => $row['forum_content'],
                    'forum_category' => $row['forum_category'],
                    'user_img' => $row['ud_img_name'] ? $row['ud_img_name'] : 'avatar2.png',
                    'username' => $row['user_username'],
                    'forum_created' => $row['forum_created_date'],
                    'role_name' => $row['role_name'],
                    'menu_allow' => $this->data['menu_allow'],
                    'user_allow_menu' => $this->data['user_allow_menu']
                );
            }
            $data['dataForum'] = $dataForum;
            if (($this->session->userdata('logged_in')['user_id'] == $dataForum['user_id']) || ($this->session->userdata('logged_in')['role_id'] == 1)) {
                $this->template->load('default', 'forum/edit', $data);
            } else {
                $this->template->load('default', '403', $data);
            }
        }
    }

    function closeForum($id = null)
    {
        if ((!in_array($this->data['menu_allow'] . '_close', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('warning_access'),
            );
        } else {
            if ($id) {
                $data = array(
                    'forum_is_closed' => 1,
                    'forum_closed_by' => $this->session->userdata('logged_in')['user_id'],
                    'forum_closed_date' => date("Y-m-d H:i:s"),
                );
                $cond = array(
                    'forum_id' => $id
                );
                $closeForum = $this->forum->update($cond, $data);
                if ($closeForum) {
                    $res =  array(
                        'is_success' => true,
                        'message' => $this->lang->line('forum_success_close'),
                    );
                } else {
                    $err = $this->db->error();
                    $message = $err["code"] . "-" . $err["message"];
                    $res =  array(
                        'is_success' => false,
                        'message' => $message,
                    );
                }
            } else {
                $res =  array(
                    'is_success' => false,
                    'message' => $this->lang->line('text_error'),
                );
            }
        }
        echo json_encode($res);
    }

    function openForum($id = null)
    {
        if ((!in_array($this->data['menu_allow'] . '_open', $this->data['user_allow_menu']))) {
            $res = array(
                'is_success' => false,
                'message' => $this->lang->line('warning_access'),
            );
        } else {
            if ($id) {
                $data = array(
                    'forum_is_closed' => null,
                    'forum_open_by' => $this->session->userdata('logged_in')['user_id'],
                    'forum_open_date' => date("Y-m-d H:i:s"),
                );
                $cond = array(
                    'forum_id' => $id
                );
                $closeForum = $this->forum->update($cond, $data);
                if ($closeForum) {
                    $res =  array(
                        'is_success' => true,
                        'message' => $this->lang->line('forum_success_open'),
                    );
                } else {
                    $err = $this->db->error();
                    $message = $err["code"] . "-" . $err["message"];
                    $res =  array(
                        'is_success' => false,
                        'message' => $message,
                    );
                }
            } else {
                $res =  array(
                    'is_success' => false,
                    'message' => $this->lang->line('text_error'),
                );
            }
        }
        echo json_encode($res);
    }
}
