<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kms extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $session_data = $this->session->userdata('logged_in');
        $this->load->model('users_model', 'users');
        $this->load->helper(array('download'));
        $this->sessionUserDetail = $this->users->sessionUserDetail();
        if (empty($session_data)) {
            redirect('auth/login', 'refresh');
        }
    }

    public function downloadUploadFile($folder = null, $filename = null)
    {
        return force_download("assets/uploads/$folder/$filename", NULL);
    }

    function getNotif()
    {
        $this->load->model('Notification_model', 'notif');
        $dataNotif = array();
        $dataDocument = array();
        $mapArray = array();
        // Menu Access Role

        // Register User
        $urlname    = strtolower('register_user');
        $menu_id    = $this->Menu_model->idMenu($urlname);
        $user_allow = $this->Menu_model->UserAllow($this->session->userdata('logged_in')['role_id']);
        $user_allow_menu = explode(",", $user_allow[0]['role_allow_menu']);
        $this->data['menu_allow'] = '';
        $this->data['menu_allow'] = 'level_' . $menu_id[0]['menu_id'];
        $this->data['user_allow_menu'] = $user_allow_menu;
        if (@in_array($menu_id[0]['menu_id'], $user_allow_menu)) {

            $dataRegis = $this->notif->getNewRegister();
            if ($dataRegis) {
                $dataNotif['register'] = $dataRegis;
            }
        }

        // Document
        $urlname    = strtolower('document');
        $menu_id    = $this->Menu_model->idMenu($urlname);
        $this->data['menu_allow'] = 'level_' . $menu_id[0]['menu_id'];
        if ((in_array($this->data['menu_allow'] . '_upload', $this->data['user_allow_menu']))) {
            $dataDocument = $this->notif->getRequestedDocument();
            $mapArray = array();
            if ($dataDocument) {
                foreach ($dataDocument as $key => $doc) {
                    $docId = $doc['document_id'];
                    $docCode = $doc['document_code'];
                    $mapArray[$key]['url'] = base_url("document/upload/$docId/$docCode");
                    $mapArray[$key]['doc_code'] = $doc['document_code'];
                    $mapArray[$key]['username'] = $doc['user_username'];
                }
                $dataNotif['document'] = $mapArray;
            }
        }
        if ((in_array($this->data['menu_allow'] . '_validasi', $this->data['user_allow_menu']))) {
            $dataDocument = $this->notif->getDocNeedApprove();
            $mapArray = array();
            if ($dataDocument) {
                foreach ($dataDocument as $key => $doc) {
                    $docId = $doc['document_id'];
                    $docCode = $doc['document_code'];
                    $mapArray[$key]['url'] = base_url("document/view/$docId/$docCode");
                    $mapArray[$key]['doc_code'] = $doc['document_code'];
                    $mapArray[$key]['username'] = $doc['user_username'];
                }
                $dataNotif['documentApprove'] = $mapArray;
            }
        }

        // Notulensi
        $urlname    = strtolower('notulensi');
        $menu_id    = $this->Menu_model->idMenu($urlname);
        $this->data['menu_allow'] = 'level_' . $menu_id[0]['menu_id'];
        if ((in_array($this->data['menu_allow'] . '_validasi', $this->data['user_allow_menu']))) {
            $dataNotulensi = $this->notif->getNoteNeedAction();
            $mapArray = array();
            if ($dataNotulensi) {
                foreach ($dataNotulensi as $key => $note) {
                    $noteId = $note['notulensi_id'];
                    $noteCode = $note['notulensi_code'];
                    $mapArray[$key]['url'] = base_url("notulensi/view/$noteId/$noteCode");
                    $mapArray[$key]['note_code'] = $note['notulensi_code'];
                    $mapArray[$key]['username'] = $note['user_username'];
                }
                $dataNotif['notulensiApprove'] = $mapArray;
            }
        }

        // Temp
        $dataTempNotif = $this->notif->getNotification();
        $mapArray = array();
        if ($dataTempNotif) {
            foreach ($dataTempNotif as $key => $notif) {
                $mapArray[$key]['url'] = $notif['notif_url'];
                $mapArray[$key]['notif_subj'] = $notif['notif_subj'];
                $mapArray[$key]['notif_msg'] = $notif['notif_msg'];
                $mapArray[$key]['notif_status'] = $notif['notif_status'];
            }
            $dataNotif['uploaded'] = $mapArray;
        }
        // print_r($dataTempNotif);die;
        $res = array(
            'is_success' => true,
            'dataNotif' => $dataNotif,
        );
        echo json_encode($res);
    }

    public function set_language($language = "")
    {
        $language = ($language != "") ? $language : "english";
        $sess_array = array(
            'user_id'             => $this->session->userdata('logged_in')['user_id'],
            'username'     => $this->session->userdata('logged_in')['username'],
            'role_id'        => $this->session->userdata('logged_in')['role_id'],
            'school_id'        => $this->session->userdata('logged_in')['school_id'],
            'language'  => $language
        );
        $this->session->set_userdata('logged_in', $sess_array);
        // print_r($this->session->userdata('logged_in'));die;
        redirect($_SERVER['HTTP_REFERER']);
    }

    public function tags()
    {
        $this->load->model('filter_model', 'filter');
        $tags = $this->filter->getForumCategory();
        $mapTags = array();
        foreach ($tags as $tag) {
            $arrTags = explode(",", $tag['forum_category']);
            foreach ($arrTags as $row) {
                $mapTags[] = $row;
            }
        }
        $uniqTags = array_unique($mapTags);
        foreach ($uniqTags as $row) {
            $newUniqTags[] = $row;
        }
        // Filter In Array
        // $input = preg_quote($q, '~'); // don't forget to quote input string!
        // $result = preg_grep('~' . $input . '~', $uniqTags);

        echo json_encode($newUniqTags);
    }

    public function tagsWithCount()
    {
        $this->load->model('filter_model', 'filter');
        $tags = $this->filter->getForumCategory();
        $mapTags = array();
        foreach ($tags as $tag) {
            $arrTags = explode(",", $tag['forum_category']);
            foreach ($arrTags as $row) {
                $mapTags[] = $row;
            }
        }

        echo json_encode(array_count_values($mapTags));
    }

    public function setNotifReaded()
    {
        $this->load->model('Notification_model', 'notif');
        $affected = $this->notif->setNotifReaded();
        // print_r($affected);die;
        $res = array(
            'is_success' => true,
            'affected' => $affected
        );
        echo json_encode($res);
    }
}
