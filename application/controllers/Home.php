<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
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
		// if (@in_array($menu_id[0]['menu_id'], $user_allow_menu)) {
		// 	$this->data['menu_allow'] = 'level_' . $menu_id[0]['menu_id'];
		// } else {
		// 	redirect('home', 'refresh');
		// }
	}

	public function index()
	{
		$data = array(
			'title' => $this->lang->line('home_title'),
			'system' => $this->system,
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
		);
		$this->template->load('default', 'home/index', $data);
	}

	public function search()
	{
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

	function loadSearchRecord($rowno = 0)
	{
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
