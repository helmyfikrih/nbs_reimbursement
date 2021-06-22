<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		//Do your magic here
		$session_data = $this->session->userdata('logged_in');
		if (empty($session_data)) {
			redirect('auth/login', 'refresh');
		}
		$this->load->model('users_model', 'users');
		$this->load->model('home_model', 'home');
		$this->load->model('settings_model', 'setting');
		$this->system = $this->setting->getSystemSettings();
		$this->load->library('pagination');
		$this->sessionUserDetail = $this->users->sessionUserDetail();
		$this->menu_body 	= $this->Menu_model->getmenu($session_data['user_id'], $session_data['username']);
		

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
		$i=0;
		$cDoc = 0;
		$cDocReq = 0;
		$cDocToday = 0;
		$cDocReqToday = 0;
		$cForum = 0;
		$cForumToday = 0;
		$cForumComment = 0;
		$cForumCommentToday = 0;
		$cNotulensi = 0;
		$cNotulensiToday = 0;
		$cUsers = 0;
		$cUsersToday = 0;
		$dataDocument = $this->home->getDocument();
		$dataForum = $this->home->getForum();
		$dataForumComment = $this->home->getForumComment();
		$dataNotulensi = $this->home->getNotulensi();
		$dataUsers = $this->home->getUsers();
		$dataAnnouncement = $this->home->getAnnouncement();
		$dataDocumentAttch = $this->home->getDocumentAttch();
		$dataDocument1 = array();
		$dataForum1 = array();
		$dataForumComment1 = array();
		$dataDocumentAttch1 = array();
		foreach($dataDocument as $doc){
			$docDate = date("Y-m-d",strtotime($doc["document_created_date"]));
			if($doc['document_status']==1){
				$cDoc++;
				$dataDocument1[] = $doc;
			}
			if ($doc['document_status'] == 3) {
				$cDocReq++;
			}
			if(($docDate==date("Y-m-d")) && ($doc['document_status'] == 1)){
				$cDocToday++;
			}
			if (($docDate == date("Y-m-d")) && ($doc['document_status'] == 3)) {
				$cDocReqToday++;
			}

		}
		foreach ($dataForum as $forum) {
			$forumDate = date("Y-m-d", strtotime($forum["forum_created_date"]));
			if ($forum['forum_status'] == 1) {
				$cForum++;
				$dataForum1[] = $forum;
			}
			
			if (($forumDate == date("Y-m-d")) && ($forum['forum_status'] == 1)) {
				$cForumToday++;
			}
		}
		foreach ($dataForumComment as $fc) {
			$fcDate = date("Y-m-d", strtotime($fc["fc_created_date"]));
			if ($fc['fc_status'] == 1) {
				$cForumComment++;
				$dataForumComment1[] = $fc;
			}
			
			if (($fcDate == date("Y-m-d")) && ($fc['fc_status'] == 1)) {
				$cForumCommentToday++;
			}
		}
		foreach ($dataNotulensi as $note) {
			$noteDate = date("Y-m-d", strtotime($note["notulensi_created_date"]));
			if ($note['notulensi_status'] == 1) {
				$cNotulensi++;
			}
			
			if (($noteDate == date("Y-m-d")) && ($note['notulensi_status'] == 1)) {
				$cNotulensiToday++;
			}
		}
		foreach ($dataUsers as $user) {
			$userDate = date("Y-m-d", strtotime($user["user_created_date"]));
			if ($user['user_status'] == 1) {
				$cUsers++;
			}
			
			if (($userDate == date("Y-m-d")) && ($user['user_status'] == 1)) {
				$cUsersToday++;
			}
		}
		foreach ($dataDocumentAttch as $attch) {
			$ext = pathinfo($attch['da_name'], PATHINFO_EXTENSION);
			if(in_array($ext,array('jpeg','jpg', 'png', 'gif'))){
				$dataDocumentAttch1[] = $attch;
			}
		}
        $data = array(
			'title' => $this->lang->line('home_title'),
            'system' => $this->system,
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'cDoc' => $cDoc,
			'cDocReq' => $cDocReq,
			'cDocToday' => $cDocToday,
			'cDocReqToday' => $cDocReqToday,
			'dataDocument' => $dataDocument1,
			'cForum' => $cForum,
			'cForumToday' => $cForumToday,
			'dataForum' => $dataForum1,
			'cForumComment' => $cForumComment,
			'cForumCommentToday' => $cForumCommentToday,
			'dataForumComment' => $dataForumComment1,
			'cNotulensi' => $cNotulensi,
			'cNotulensiToday' => $cNotulensiToday,
			'dataNotulensi' => $dataNotulensi,
			'cUsers' => $cUsers,
			'cUsersToday' => $cUsersToday,
			'dataUsers' => $dataUsers,
			'dataAnnouncement' => $dataAnnouncement,
			'dataDocumentAttch' => $dataDocumentAttch1,
		);
		$this->template->load('default', 'home/index', $data);
	}

	public function search(){
		$q = $this->input->get('q');
		// Row per page
		// $dataResult = $this->home->search($q);
		$this->home->insertSearchLog($q);
		$allcount = $this->home->getSearchListCount($q);
		$data = array(
			'title' => $this->lang->line('search_title'),
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'allCount' => $allcount,
			'q' => $q,
			'system' => $this->system
			// 'dataResult' => $dataResult,
		);
		// print_r($data);die;
		$this->template->load('default', 'home/search', $data);
	}

	function loadSearchRecord($rowno=0){
		// Row per page
		$q = $this->input->get('q');
		// $rowno=  $this->input->get('p');;
		$rowperpage = 5;
		if ($rowno != 0) {
			$rowno = ($rowno - 1) * $rowperpage;
		}

		// All records count
		$allcount = $this->home->getSearchListCount($q);
		// Get records
		$search_record = $this->home->getSearchList($rowno, $rowperpage, $q);
		// print_r($this->db->last_query());die;

		// Pagination Configuration
		$config['base_url'] = base_url() . '/home/loadSearchRecord';
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
		$data['result'] = $search_record;
		$data['row'] = $rowno;

		echo json_encode($data);
	}
}
