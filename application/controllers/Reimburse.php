<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Reimburse extends CI_Controller
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
		$this->load->model('reimburse_model', 'reimburse');
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
			'title' => "Reimburse List",
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'menu_allow' => $this->data['menu_allow'],
			'user_allow_menu' => $this->data['user_allow_menu'],
			'system' => $this->system,
		);
		$this->template->load('default', 'reimburse/index', $data);
	}

	public function create()
	{
		$this->load->model('filter_model', 'filter');
		$reimburseType = $this->filter->getReimburseType();
		$data = array(
			'title' => $this->lang->line('document_create'),
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'system' => $this->system,
			'reimburseType' => $reimburseType,
		);
		if ((!in_array($this->data['menu_allow'] . '_add', $this->data['user_allow_menu']))) {
			$res = array(
				'is_success' => false,
				'message' => $this->lang->line('warning_access'),
			);
			$this->template->load('default', '403', $data);
		} else {
			$this->template->load('default', 'reimburse/create', $data);
		}
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

		$userId = $this->session->userdata('logged_in')['user_id'];
		$reimburse_value = $this->input->post('reimburse_value');
		$reimburse_type = $this->input->post('reimburse_type');
		$reimburse_start_date = $this->input->post('reimburse_start_date');
		$reimburse_end_date = $this->input->post('reimburse_end_date');
		$reimburse_note = $this->input->post('reimburse_note');
		$file = $_FILES;
		$reimburse_id = $this->input->post('reimburse_id');
		if (!$reimburse_id) {
			$state = "Create";
			$msg = "Berhasil Membuat Claim";
			$data = array(
				'reimburse_type_id' => $reimburse_type,
				'user_id' => $userId,
				'reimburse_start_date' => $reimburse_start_date,
				'reimburse_end_date' => $reimburse_end_date,
				'reimburse_value' => $reimburse_value,
				'reimburse_note' => $reimburse_note,
				'reimburse_status' => 2,
				'reimburse_created_at' => date("Y-m-d H:i:s"),
			);
			$this->reimburse->insertReimburse($data);
			$reimburse_id = $this->db->insert_id();
		} else {
			$msg = "Berhasil Ubah Claim";
			$data = array(
				'reimburse_type_id' => $reimburse_type,
				'user_id' => $userId,
				'reimburse_start_date' => $reimburse_start_date,
				'reimburse_end_date' => $reimburse_end_date,
				'reimburse_value' => $reimburse_value,
				'reimburse_note' => $reimburse_note,
			);
			$this->reimburse->updateReimburse($reimburse_id, $data);
			$reimburse_id = $reimburse_id;
		}

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
					$config['upload_path'] = './assets/uploads/reimburse';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xlc|xlcx|pdf|mp4|mp3|mov|avi|mpeg4';
					// $config['allowed_types'] = 'pdf';
					$config['max_size'] = '10000'; // max_size in kb
					$config['overwrite'] = FALSE;
					$config['file_name'] = $reimburse_id . '_' . date("ymdhis") . '_' . $i;
					if (!file_exists($config['upload_path'])) {
						mkdir($config['upload_path'], 0777, true);
					}
					//Load upload library
					$this->load->library('upload', $config);
					$this->upload->initialize($config);
					// File upload
					if (!$this->upload->do_upload('file')) {
						// Get data about the file
						$res = array(
							'is_success' => false,
							'message' => $this->upload->display_errors()
						);
						echo json_encode($res);
						exit;
					} else {
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];
						$dataUpload[] = array(
							'reimburse_id' => $reimburse_id,
							'user_id' => $this->sessionUserDetail['user_id'],
							'reimburse_attachment_name' =>  $filename,
							'reimburse_attachment_dir' => ".assets/uploads/reimburse/$filename",
							'reimburse_attachment_url' => base_url('assets/uploads/reimburse/') . $filename,
							'reimburse_attachment_client_name' => $filename,
						);
					}
				}
			}
			$this->reimburse->inserAttachment($dataUpload);
		} else {
			$res = array(
				'is_success' => true,
				'message' => $msg,
			);
		}
		if ($this->db->trans_status() === FALSE) {
			$this->db->trans_rollback();
			$err = $this->db->error();
			$msg = $err["code"] . "-" . $err["message"];
			$res = array(
				'is_success' => false,
				'message' =>  $msg
			);
		} else {
			$this->db->trans_commit();
			$res = array(
				'is_success' => true,
				'message' => $msg
			);
		}
		echo json_encode($res);
	}

	public function getList()
	{
		$cond = array(
			'reimburse_status !=' => 0
		);
		// if ($this->sessionUserDetail['role_id'] == 4) {
		// 	$cond['reimburse_status'] = 1;
		// }
		// if ($this->sessionUserDetail['role_id'] == 1) {
		//     $cond = array();
		// }
		$userId = $this->session->userdata('logged_in')['user_id'];
		$filter_school = $this->input->post('filter_school');
		$filter_docCategory = $this->input->post('filter_docCategory');
		$filter_subject = $this->input->post('filter_subject');
		$filter_status = $this->input->post('filter_status');
		if ($filter_school != 0 || $filter_school != '0') {
			$cond['ksc.school_id'] = DecryptString($filter_school);
		}
		if ($filter_docCategory != 0 || $filter_docCategory != '0') {
			$cond['kdt.doctype_id'] = DecryptString($filter_docCategory);
		}
		if ($filter_subject != 0 || $filter_subject != '0') {
			$cond['ks.subject_id'] = DecryptString($filter_subject);
		}
		if ($filter_status != 0 || $filter_status != '0') {
			$cond['reimburse_status'] = DecryptString($filter_status);
			if ($this->sessionUserDetail['role_id'] == 4) {
				$cond['reimburse_status'] = 1;
			}
		}
		if ((!in_array($this->data['menu_allow'] . '_validasi', $this->data['user_allow_menu']))) {
			$cond['kd.user_id'] = $userId;
		}
		$list = $this->reimburse->getList($cond);
		// print_r($this->data['user_allow_menu']);die;
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
			$hidden = "";
			$btnUpload = "";
			$btnUpload2 = "";
			$btnEdit = "";
			$btnEdit2 = "";
			$btnView = "";
			$btnView2 = "";
			$btnDelete = "";
			$btnDelete2 = "";
			if ((in_array($this->data['menu_allow'] . '_validasi', $this->data['user_allow_menu'])) && ($field->reimburse_status == 2)) {

				$btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('reimburse/view/' . $field->reimburse_id . '/' . $field->user_id) . '" title="' . $this->lang->line('document_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
				$btnView2 = '<li>
                                    <a href="' . base_url('reimburse/view/' . $field->reimburse_id . '/' . $field->user_id) . '" class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('document_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
			}
			if ((in_array($this->data['menu_allow'] . '_view', $this->data['user_allow_menu']))) {
				$btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('reimburse/view/' . $field->reimburse_id . '/' . $field->user_id) . '" title="' . $this->lang->line('document_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
				$btnView2 = '<li>
                                    <a href="' . base_url('reimburse/view/' . $field->reimburse_id . '/' . $field->user_id) . '" class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('document_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
			}
			if ((in_array($this->data['menu_allow'] . '_view', $this->data['user_allow_menu'])) && ($this->sessionUserDetail['role_id'] == 1) && in_array($field->reimburse_status, array(1, 2, 4))) {
				$btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('reimburse/view/' . $field->reimburse_id . '/' . $field->user_id) . '" title="' . $this->lang->line('document_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
				$btnView2 = '<li>
                                    <a href="' . base_url('reimburse/view/' . $field->reimburse_id . '/' . $field->user_id) . '" class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('document_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
			}
			if (($field->reimburse_status == 3) && (in_array($this->data['menu_allow'] . '_upload', $this->data['user_allow_menu']))) {
				$label = 'info';
				$text = $this->lang->line('reimburse_status_request');
				$btnUpload = '<a class="blue" data-rel="tooltip" data-placement="bottom" href="' . base_url('reimburse/upload/' . $field->reimburse_id . '/' . $field->user_id) . '" title="' . $this->lang->line('document_upload') . '">
                            <i class="ace-icon fa fa-upload bigger-130"></i>
                        </a>';
				$btnUpload2 = '<li>
                                    <a  href="' . base_url('reimburse/upload/' . $field->reimburse_id . '/' . $field->user_id) . '" class="tooltip-success" data-rel="tooltip" title="' . $this->lang->line('document_upload') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-upload bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
			} else if ($field->reimburse_status == 3) {
				$label = 'info';
				$text = $this->lang->line('reimburse_status_request');
			}
			if ($field->reimburse_status == 4) {
				$label = 'danger';
				$text = "Rejected";
				$hidden = "hidden";
			}
			if ($field->reimburse_status == 0) {
				$label = 'danger';
				$text = $this->lang->line('reimburse_status_delete');
				$hidden = "hidden";
			}
			if ($field->reimburse_status == 1) {
				$label = 'success';
				$text = "Approved";
			}
			if ($field->reimburse_status == 2) {
				$label = 'warning';
				$text = "Waiting Approval";
			}

			if ((in_array($field->reimburse_status, array(2, 3))) && (in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
				if (($this->session->userdata('logged_in')['role_id'] == 1) || ($field->user_id == $this->session->userdata('logged_in')['user_id'])) {

					$btnEdit = '<a class="green" data-rel="tooltip" data-placement="bottom" href="' . base_url('reimburse/edit/' . $field->reimburse_id . '/' . $field->user_id) . '" title="' . $this->lang->line('document_edit') . '">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>';
					$btnEdit2 = '<li>
                                    <a  href="' . base_url('reimburse/edit/' . $field->reimburse_id . '/' . $field->user_id) . '" class="tooltip-success" data-rel="tooltip" title="' . $this->lang->line('document_edit') . '">
                                        <span class="green">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
				}
			}
			if ((in_array($this->data['menu_allow'] . '_delete', $this->data['user_allow_menu']) && $field->reimburse_status == 2)) {
				$btnDelete = '<a class="red" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="approval(0,' . $field->reimburse_id . ', \'' . $field->user_id . '\')" title="' . $this->lang->line('document_delete') . '">
                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                        </a>';
				$btnDelete2 = '<li>
                                    <a href="javascript:;" onclick="approval(0,' . $field->reimburse_id . ', \'' . $field->user_id . '\')" class="tooltip-error" data-rel="tooltip" title="' . $this->lang->line('document_delete') . '">
                                        <span class="red">
                                            <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
			}
			$btn = '<div class="hidden-sm hidden-xs action-buttons">
                    ' . $btnView . $btnUpload . $btnEdit . $btnDelete . '
                    </div>
                    <div class="hidden-md hidden-lg" ' . $hidden . '>
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

			$content = strlen($field->reimburse_note) > 50 ? substr($field->reimburse_note, 0, 50) . "..." : $field->reimburse_note;
			$status = '<span class="label label-sm label-' . $label . '">' . $text . '</span>';
			$reimburseDate = date("H:i:s d-m-Y", strtotime($field->reimburse_created_at));
			// $row[] = $chkBox;
			$row[] = $field->user_username;
			$row[] = P($reimburseDate);
			// $row[] = ($content);
			$row[] = $field->reimburse_value;
			$row[] = $status;
			$row[] = $btn;
			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->reimburse->count_new($cond),
			"recordsFiltered" => $this->reimburse->count_filtered_new($cond),
			"data"            => $data,
		);
		//output dalam format JSON

		echo json_encode($output);
	}

	public function upload()
	{
		$reimburseId = $this->uri->segment(3);
		$reimburseUserId = $this->uri->segment(4);
		$doc_status = '(3)';
		$document = $this->reimburse->getOneReimburse($reimburseId, $reimburseUserId, $doc_status);

		$data = array(
			'title' => 'Upload Reimburse',
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'docDetail' => $document,
			'system' => $this->system
		);
		if ((!in_array($this->data['menu_allow'] . '_upload', $this->data['user_allow_menu']))) {
			$res = array(
				'is_success' => false,
				'message' => $this->lang->line('warning_access'),
			);
			$this->template->load('default', '403', $data);
		} else {
			if ($document) {
				$this->template->load('default', 'reimburse/upload', $data);
			} else {
				$this->template->load('default', '404', $data);
			}
		}
	}

	public function saveUpload()
	{
		if ((!in_array($this->data['menu_allow'] . '_upload', $this->data['user_allow_menu']))) {
			$res = array(
				'is_success' => false,
				'message' => $this->lang->line('warning_access'),
			);
			echo json_encode($res);
			exit;
		}
		$file = $_FILES;
		$insert_id = $this->input->post('doc_id');
		$reimburseUserId = $this->input->post('doc_code');
		$getUserRequest = $this->reimburse->getDocUser($insert_id, $reimburseUserId);
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
					$config['upload_path'] = './assets/uploads/document';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xlc|xlcx';
					$config['max_size'] = '5000'; // max_size in kb
					$config['overwrite'] = FALSE;
					$config['file_name'] = $insert_id . '_' . $reimburseUserId . '_' . $i;

					//Load upload library
					$this->load->library('upload', $config);

					// File upload
					if (!$this->upload->do_upload('file')) {
						// Get data about the file
						$res = array(
							'is_success' => false,
							'message' => $this->upload->display_errors()
						);
					} else {
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];
						$dataUpload[$i]['reimburse_id'] = $insert_id;
						$dataUpload[$i]['user_id'] = $this->session->userdata('logged_in')['user_id'];
						$dataUpload[$i]['da_name'] = $filename;
						$dataUpload[$i]['da_dir'] = base_url('assets/uploads/reimburse/') . $filename;
						$dataUpload[$i]['da_created_date'] = date('Y-m-d H:i:s');
						$dataUpload[$i]['da_status'] = 1;
						// Initialize array
					}
				}
			}
			$this->db->trans_begin();
			$this->reimburse->inserAttachment($dataUpload);
			$dataDoc = array(
				'reimburse_status' => 2,
				'document_last_update' => date("Y-m-d H:i:s"),
				'document_last_update_by' => $this->session->userdata('logged_in')['user_id'],
			);
			$this->reimburse->updateReimburse($insert_id, $dataDoc);
			if ($this->db->trans_status() === FALSE) {
				$this->db->trans_rollback();
				$err = $this->db->error();
				$msg = $err["code"] . "-" . $err["message"];
				$res = array(
					'is_success' => false,
					'message' =>  $msg
				);
			} else {
				$this->db->trans_commit();
				$res = array(
					'is_success' => true,
					'message' => $this->lang->line('document_success_upload'),
				);
				$uploader = $this->sessionUserDetail['username'];
				$requester = $getUserRequest['user_username'];
				$dataTemplate = array(
					'header' => "Notification",
					'text' => "Dear $requester,<br/><b> $uploader </b> Has uploaded your requested document. Please wait for approval.",
					'btnText' => null,
					'btnLink' => null
				);
				$message = $this->load->view('template/mail', $dataTemplate, TRUE);
				if ($uploader != $requester) {
					$this->load->helper('Mail_helper');
					sendMail($getUserRequest['user_email'], 'Notification', $message, null, 'KMSchool');
					$dataNotif = array(
						'user_id' => $getUserRequest['user_id'],
						'notif_subj' => 'uploaded',
						'notif_msg' =>  "<b>$uploader</b> Has uploaded your requested document. Please wait for approval.",
						'notif_url' =>  site_url('document'),
						'notif_status' => 0,
						'notif_date' => date('Y-m-d H:i:s')
					);

					$this->db->insert('kms_notification', $dataNotif);
				}
			}
		} else {
			$res = array(
				'is_success' => true,
				'message' => $this->lang->line('document_success_upload'),
			);
		}
		echo json_encode($res);
	}

	public function view()
	{
		$reimburseId = $this->uri->segment(3);
		$reimburseUserId = $this->uri->segment(4);
		$doc_status = '(2,3)';
		$cond = array(
			'kd.user_id' => $reimburseUserId,
			'kd.reimburse_id' => $reimburseId,
		);
		$reimburse = $this->reimburse->getOneReimburse($cond);
		$reimburseAttachment = $this->reimburse->getOneReimburseAttachment($reimburseId);
		$reimburseApprovalManagement = $this->reimburse->getOneReimburseApprovalManagement($reimburseId);
		$data = array(
			'title' => $this->lang->line('document_edit'),
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'reimburseDetail' => $reimburse,
			'reimburseAttachment' => $reimburseAttachment,
			'reimburseApprovalManagement' => $reimburseApprovalManagement,
			'menu_allow' => $this->data['menu_allow'],
			'user_allow_menu' => $this->data['user_allow_menu'],
			'system' => $this->system,
		);
		if ($reimburse) {
			if ($reimburse[0]['reimburse_status'] == 4 && $this->sessionUserDetail['role_id'] == 1) {
				$this->template->load('default', 'reimburse/view', $data);
			} else if (in_array($reimburse[0]['reimburse_status'], array(2))) {
				$this->template->load('default', 'reimburse/view', $data);
			} else if (in_array($reimburse[0]['reimburse_status'], array(1)) && (in_array($this->data['menu_allow'] . '_view', $this->data['user_allow_menu']))) {
				$this->template->load('default', 'reimburse/view', $data);
			} else {
				$this->template->load('default', '403', $data);
			}
		} else {
			$this->template->load('default', '404', $data);
		}
	}

	public function approval()
	{
		$status = $this->input->post('status');
		if (($status != 0) && (!in_array($this->data['menu_allow'] . '_validasi', $this->data['user_allow_menu']))) {
			$res = array(
				'is_success' => false,
				'message' => $this->lang->line('warning_access'),
			);
			echo json_encode($res);
			exit;
		}
		if (($status == 0) && (!in_array($this->data['menu_allow'] . '_delete', $this->data['user_allow_menu']))) {
			$res = array(
				'is_success' => false,
				'message' => $this->lang->line('warning_access'),
			);
			echo json_encode($res);
			exit;
		}
		$reimburseId = $this->input->post('doc_id');
		$reimburseUserId = $this->input->post('doc_code');
		$data = array(
			'reimburse_status' => $status,
		);
		$approve = $this->reimburse->updateReimburse($reimburseId, $data);
		// $docUser = $this->reimburse->getDocUser($reimburseId, $reimburseUserId);
		if ($status == 1) {
			$approval = "Validated";
			$url = site_url("reimburse/view/$reimburseId/$reimburseUserId");
			$msg = "Claim Approved";
		}
		if ($status == 4) {
			$approval = "Rejected";
			$url = site_url("reimburse/");
			$msg = "Claim Rejected";
		}
		if ($status == 0) {
			$approval = "Deleted";
			$url = site_url("reimburse/");
			$msg = $this->lang->line('document_approval_delete');
		}
		if ($approve) {
			$res = array(
				'is_success' => true,
				'message' => $msg,
			);

			// $approver = $this->sessionUserDetail['username'];
			// $owner = $docUser['user_username'];
			// $dataTemplate = array(
			// 	'header' => "Notification",
			// 	'text' => "Dear $owner,<br/><b> $approver </b> Has $approval your document.",
			// 	'btnText' => null,
			// 	'btnLink' => null
			// );
			// $message = $this->load->view('template/mail', $dataTemplate, TRUE);
			// if ($owner != $approver) {
			// 	$this->load->helper('Mail_helper');
			// 	sendMail($docUser['user_email'], 'Notification', $message, null, 'KMSchool');
			// 	$dataNotif = array(
			// 		'user_id' => $docUser['user_id'],
			// 		'notif_subj' => 'uploaded',
			// 		'notif_msg' =>  "<b>$approver</b> Has $approval your document.",
			// 		'notif_url' =>   $url,
			// 		'notif_status' => 0,
			// 		'notif_date' => date('Y-m-d H:i:s')
			// 	);

			// 	$this->db->insert('kms_notification', $dataNotif);
			// }
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

	public function edit()
	{
		$this->load->model('filter_model', 'filter');
		$reimburseId = $this->uri->segment(3);
		$reimburseUserId = $this->uri->segment(4);
		$doc_status = '(2,3)';
		$cond = array(
			'kd.user_id' => $reimburseUserId,
			'kd.reimburse_id' => $reimburseId,
		);
		$reimburse = $this->reimburse->getOneReimburse($cond);
		$reimburseAttachment = $this->reimburse->getOneReimburseAttachment($reimburseId);
		$reimburseType = $this->filter->getReimburseType();
		$data = array(
			'title' => $this->lang->line('document_edit'),
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'reimburseDetail' => $reimburse,
			'reimburseAttachment' => $reimburseAttachment,
			'system' => $this->system,
			'reimburseType' => $reimburseType,
		);
		if ((!in_array($this->data['menu_allow'] . '_upload', $this->data['user_allow_menu']))) {
			$res = array(
				'is_success' => false,
				'message' => $this->lang->line('warning_access'),
			);
			$this->template->load('default', '403', $data);
		} else {
			if ($reimburse) {
				$this->template->load('default', 'reimburse/edit', $data);
			} else {
				$this->template->load('default', '404', $data);
			}
		}
	}

	public function saveEdit()
	{
		$reimburseId = $this->input->post('reimburse_id');
		$doctype_id = $this->input->post('reimburseType');
		$subject_id = $this->input->post('subject');
		$reimburseUserId = $this->input->post('user_id');
		$docName = $this->input->post('document_name');
		$docDesc = $this->input->post('document_desc');
		$userId = $this->session->userdata('logged_in')['user_id'];
		$data = array(
			'doctype_id' => $doctype_id,
			'subject_id' => $subject_id,
			'document_name' => $docName,
			'document_desc' => $docDesc,
			'document_last_update' => date("Y-m-d H:i:s"),
			'document_last_update_by' => $userId,
		);

		$file = $_FILES;
		$updateDoc = $this->reimburse->updateReimburse($reimburseId, $data);
		if ($file && $updateDoc) {
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
					$config['upload_path'] = './assets/uploads/document';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xlc|xlcx|pdf|mp4|mp3|mov|avi|mpeg4';
					// $config['allowed_types'] = 'pdf';
					$config['max_size'] = '5000'; // max_size in kb
					$config['overwrite'] = FALSE;
					$config['file_name'] = $reimburseId . '_' . $reimburseUserId . '_' . $i;

					//Load upload library
					$this->load->library('upload', $config);
					// File upload
					if (!$this->upload->do_upload('file')) {
						// Get data about the file
						$res = array(
							'is_success' => false,
							'message' => $this->upload->display_errors()
						);
					} else {
						$uploadData = $this->upload->data();
						$filename = $uploadData['file_name'];
						$dataUpload[$i]['reimburse_id'] = $reimburseId;
						$dataUpload[$i]['user_id'] = $userId;
						$dataUpload[$i]['da_name'] = $filename;
						$dataUpload[$i]['da_dir'] = base_url('assets/uploads/reimburse/') . $filename;
						$dataUpload[$i]['da_created_date'] = date('Y-m-d H:i:s');
						$dataUpload[$i]['da_status'] = 1;
						// Initialize array
					}
				}
			}
			$insertAttachment = $this->reimburse->inserAttachment($dataUpload);
			if ($insertAttachment) {
				$res = array(
					'is_success' => true,
					'message' => $this->lang->line('document_success_edit'),
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
				'message' => $this->lang->line('document_success_edit'),
			);
		}
		echo json_encode($res);
	}

	public function deleteImg()
	{
		$id = $this->input->post('imgId');
		$delete = $this->reimburse->deleteImg($id);
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

		echo json_encode($res);
	}
}
