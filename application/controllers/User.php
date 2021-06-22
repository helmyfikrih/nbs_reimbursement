<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends CI_Controller
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
		$this->load->model('schools_model', 'schools');
		$this->load->model('role_model', 'role');
		$this->load->model('designation_model', 'designation');
		$this->load->model('subject_model', 'subject');
		$this->load->model('settings_model', 'setting');

		$this->system = $this->setting->getSystemSettings();
		$this->sessionUserDetail = $this->users->sessionUserDetail();
		$this->dataRole = $this->role->getAllRole();
		$this->dataSchools = $this->schools->getAllSchools();
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
			'title' => 'User List',
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'system' => $this->system,
			'menu_allow' => $this->data['menu_allow'],
			'user_allow_menu' => $this->data['user_allow_menu'],
		);
		$this->template->load('default', 'user/index', $data);
	}

	public function create()
	{
		$data = array(
			'title' => $this->lang->line('users_create'),
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'dataRole' => $this->dataRole,
			'dataSchools' => $this->dataSchools,
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
			$this->template->load('default', 'user/create', $data);
		}
	}

	public function checkUsername()
	{
		$username = $this->input->post('username');
		$isExist = $this->users->isExistusername($username);
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

	public function checkEmail()
	{
		$email = $this->input->post('email');
		$isExist = $this->users->isExistEmail($email);
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
		$insertUser = null;
		$updateuser = null;
		$insertUserDetail = null;
		$updateUserDetail = null;
		$state = null;
		$userId = $this->session->userdata('logged_in')['user_id'];
		$userEditId = $this->input->post('user_id');
		$username =  $this->input->post('user_username');
		// $school_id =  $this->input->post('user_school');
		$password =  $this->input->post('user_password');
		$roleId =  $this->input->post('user_role');
		$jabatanId =  $this->input->post('user_position');
		$mapelId =  $this->input->post('user_mapel');
		$fullname =  $this->input->post('user_full_name');
		$address =  $this->input->post('user_address');
		$birthPlace =  $this->input->post('user_place_birth');
		$birthDate =  date("Y-m-d", strtotime($this->input->post('user_date_birth')));
		$phone =  $this->input->post('user_telp');
		$email =  $this->input->post('user_email');
		$nik =  $this->input->post('user_nik');
		$status = $this->input->post('user_status');
		$sex = $this->input->post('user_sex');

		$dataUser = array(
			'role_id' => $roleId,
			'user_username' => $username,
			// 'school_id' => $school_id,
			'user_status' => $status,
			'user_email' => $email
		);

		$cond = array(
			'user_id' => $userEditId
		);
		if ($password) {
			$dataUser['user_password'] = md5($password);
		}
		if ($userEditId) {
			$state = "Edit";
			$updateuser =  $this->users->updateUser($dataUser, $cond);
			$msg = $this->lang->line('users_success_edit');
		} else {
			$state = "Create";
			$dataUser['user_created_date'] = date("Y-m-d H:i:s");
			$dataUser['user_created_by'] =  $userId;
			$insertUser =  $this->users->insertUser($dataUser);
			$msg = $this->lang->line('users_success_create');
		}
		if ($insertUser  ||  $updateuser) {
			$dataUserDetail = array(
				'user_id' => $userEditId ? $userEditId : $this->db->insert_id(),
				'designation_id' => $jabatanId,
				'subject_id' => $mapelId,
				'user_f_name' => $fullname,
				'ud_gender' => $sex,
				'ud_nik' => $nik,
				'ud_address' => $address,
				'ud_birth_place' => $birthPlace,
				'ud_birth_date' => $birthDate,
				'ud_phone' => $phone,
			);
			if ($userEditId) {
				$updateUserDetail =  $this->users->updateUserDetail($dataUserDetail, $cond);
			} else {
				$insertUserDetail =  $this->users->insertUserDetail($dataUserDetail);
			}
		}
		if (($insertUser && $insertUserDetail) || ($updateuser && $updateUserDetail)) {
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

	public function getList()
	{

		$cond = array(
			'user_status !=' => null
		);
		$list = $this->users->getList($cond);
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
			$btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('user/view/' . $field->u_id . '/' . $field->user_username) . '" title="' . $this->lang->line('users_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
			$btnView2 = '<li>
                                    <a href="' . base_url('user/view/' . $field->u_id . '/' . $field->user_username) . '"  class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('users_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
			if ((in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
				$btnEdit = '<a class="green" data-rel="tooltip" data-placement="bottom" href="' . base_url('user/edit/' . $field->u_id . '/' . $field->user_username) . '" title="' . $this->lang->line('users_edit') . '">
                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                            </a>';
				$btnEdit2 = '<li>
                                        <a  href="' . base_url('user/edit/' . $field->u_id . '/' . $field->user_username) . '" class="tooltip-success" data-rel="tooltip" title="' . $this->lang->line('users_edit') . '">
                                            <span class="green">
                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                            </span>
                                        </a>
                                    </li>';
			}
			if ($field->user_status == 1) {
				$label = 'success';
				$text = $this->lang->line('users_status_active');
			}
			if ($field->user_status == 2) {
				$label = 'warning';
				$text = $this->lang->line('users_status_waiting');
			}
			if ($field->user_status == 4) {
				$label = 'danger';
				$text = $this->lang->line('users_status_reject');;
			}
			if ($field->user_status == 0) {
				$label = 'danger';
				$text = $this->lang->line('users_status_inactive');;
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
			$userDate = date("H:i:s d-m-Y", strtotime($field->user_created_date));
			if ($field->ud_img_name) {
				$avatar = $field->ud_img_name;
			} else {
				$avatar = "avatar2.png";
			}
			// $row[] = $chkBox;
			$row[] = '<img  width="150" height="150" class="center img-thumbnail" alt="Alex Does avatar" src="' . base_url() . 'assets/images/avatars/' . $avatar . '">';
			$row[] = $field->user_f_name;
			$row[] = $field->u_id;
			$row[] = $field->user_username;
			$row[] = $field->ud_address;
			$row[] = $field->role_name;
			$row[] = $field->designation_name;
			$row[] = $field->school_name;
			$row[] = $field->user_created_date;
			$row[] = $status;
			$row[] = $btn;
			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->users->count_new($cond),
			"recordsFiltered" => $this->users->count_filtered_new($cond),
			"data"            => $data,
		);
		//output dalam format JSON

		echo json_encode($output);
	}

	public function view()
	{
		$userId = $this->uri->segment(3);
		$username = $this->uri->segment(4);
		$status = '(1,2)';
		$userDetail = $this->users->getOneUser($userId, $username, $status);

		$data = array(
			'title' => $userDetail[0]['user_username'],
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'userDetail' => $userDetail,
			'system' => $this->system
		);
		if ($userDetail) {
			$this->template->load('default', 'user/view', $data);
		} else {
			$this->template->load('default', '404', $data);
		}
	}

	public function edit()
	{
		$userId = $this->uri->segment(3);
		$username = $this->uri->segment(4);
		$status = '(1,2)';
		$userDetail = $this->users->getOneUser($userId, $username, $status);

		$data = array(
			'title' => $this->lang->line('users_edit'),
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'userDetail' => $userDetail,
			'dataSchools' => $this->dataSchools,
			'dataRole' => $this->dataRole,
			'dataDesignation' => $this->dataDesignation,
			'dataSubject' => $this->dataSubject,
			'system' => $this->system
		);
		if ($userDetail) {
			if ((!in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
				$res = array(
					'is_success' => false,
					'message' => $this->lang->line('warning_access'),
				);
				$this->template->load('default', '404', $data);
			} else {
				$this->template->load('default', 'user/edit', $data);
			}
		} else {
			$this->template->load('default', '404', $data);
		}
	}
}
