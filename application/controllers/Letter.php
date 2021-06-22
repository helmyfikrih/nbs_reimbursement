<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Letter extends CI_Controller
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
		$this->load->model('letter_model', 'letter');
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
			'title' => "Surat",
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'menu_allow' => $this->data['menu_allow'],
			'user_allow_menu' => $this->data['user_allow_menu'],
			'system' => $this->system,
			'filterSchools' => $this->filter->getSchools(),
			'filterDocCategory' => $this->filter->getDocCategory(),
			'filterSubject' => $this->filter->getSubjects(),
		);
		$this->template->load('default', 'letter/index', $data);
	}

	public function create()
	{
		$this->load->model('filter_model', 'filter');
		$dataSchool = $this->filter->getSchools(1);
		$documentType = $this->filter->getDocumentType();
		$subjects = $this->filter->getSubjects();
		$data = array(
			'title' => $this->lang->line('document_create'),
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'system' => $this->system,
			'documentType' => $documentType,
			'subjects' =>   $subjects,
			'schools' => $dataSchool
		);
		if ((!in_array($this->data['menu_allow'] . '_add', $this->data['user_allow_menu']))) {
			$res = array(
				'is_success' => false,
				'message' => $this->lang->line('warning_access'),
			);
			$this->template->load('default', '403', $data);
		} else {
			$this->template->load('default', 'letter/create', $data);
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
		$surat_id = $this->input->post('surat_id');
		$surat_nomor = $this->input->post('surat_nomor');
		$surat_jenis = $this->input->post('surat_jenis');
		$surat_asal = $this->input->post('surat_asal');
		$surat_tujuan = $this->input->post('surat_tujuan');
		$surat_keterangan = $this->input->post('surat_keterangan');
		$userId = $this->session->userdata('logged_in')['user_id'];

		$this->db->trans_begin();

		$file = $_FILES;
		if (!$surat_id) {
			$state = "Create";
			$msg = "Berhasil Membuat Surat";
			$data = array(
				'surat_nomor' => $surat_nomor,
				'user_id' => $userId,
				'surat_jenis' => $surat_jenis,
				'surat_asal' => $surat_asal,
				'surat_tujuan' => $surat_tujuan,
				'surat_keterangan' => $surat_keterangan,
				'surat_status' => 2,
				'surat_created_date' => date("Y-m-d H:i:s"),
			);
			$this->letter->insertDocument($data);
			$letter_id = $this->db->insert_id();
		} else {
			$msg = "Berhasil Ubah Surat";
			$data = array(
				'surat_nomor' => $surat_nomor,
				'surat_jenis' => $surat_jenis,
				'surat_asal' => $surat_asal,
				'surat_tujuan' => $surat_tujuan,
				'surat_keterangan' => $surat_keterangan,
				'surat_modified_date' => date("Y-m-d H:i:s"),
				'surat_modified_by' => $userId,
			);
			$this->letter->updateDocument($surat_id, $data);
			$letter_id = $surat_id;
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
					$config['upload_path'] = './assets/uploads/letter';
					$config['allowed_types'] = 'jpg|jpeg|png|gif|pdf|doc|docx|xlc|xlcx|pdf|mp4|mp3|mov|avi|mpeg4';
					// $config['allowed_types'] = 'pdf';
					$config['max_size'] = '10000'; // max_size in kb
					$config['overwrite'] = FALSE;
					$config['file_name'] = $letter_id . '_' . date("ymdhis") . '_' . $i;
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
						$dataUpload[$i]['surat_id'] = $letter_id;
						$dataUpload[$i]['user_id'] = $userId;
						$dataUpload[$i]['sa_name'] = $filename;
						$dataUpload[$i]['sa_dir'] = base_url('assets/uploads/letter/') . $filename;
						$dataUpload[$i]['sa_created_date'] = date('Y-m-d H:i:s');
						$dataUpload[$i]['sa_status'] = 1;
						// Initialize array
					}
				}
			}
			$this->letter->inserAttachment($dataUpload);
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
			$uploader = $this->sessionUserDetail['username'];
			$uploaderEmail = $this->sessionUserDetail['email'];
			$dataTemplate = array(
				'header' => "Notification",
				'text' => "Dear $uploader, <br/> Your Letter has been submited. Please wait for us processing your request.",
				'btnText' => null,
				'btnLink' => null
			);
			$message = $this->load->view('template/mail', $dataTemplate, TRUE);
			if ($uploader) {
				$this->load->helper('Mail_helper');
				if (!$surat_id) {
					sendMail($uploaderEmail, 'Notification', $message, null, 'KMSchool');
					$dataNotif = array(
						'user_id' => $this->sessionUserDetail['user_id'],
						'notif_subj' => 'submited',
						'notif_msg' =>  "<b>$uploader</b> Has submited new letter.",
						'notif_url' =>  site_url('letter'),
						'notif_status' => 0,
						'notif_date' => date('Y-m-d H:i:s')
					);
					$this->db->insert('kms_notification', $dataNotif);
				}
			}
		}
		echo json_encode($res);
	}

	public function getList()
	{
		$cond = array(
			'surat_status !=' => 0
		);
		if ($this->sessionUserDetail['role_id'] == 4) {
			$cond['surat_status'] = 1;
		}
		// if ($this->sessionUserDetail['role_id'] == 1) {
		//     $cond = array();
		// }
		// $filter_school = $this->input->post('filter_school');
		// $filter_docCategory = $this->input->post('filter_docCategory');
		// $filter_subject = $this->input->post('filter_subject');
		// $filter_status = $this->input->post('filter_status');
		// if ($filter_school != 0 || $filter_school != '0') {
		//     $cond['ksc.school_id'] = DecryptString($filter_school);
		// }
		// if ($filter_docCategory != 0 || $filter_docCategory != '0') {
		//     $cond['kdt.doctype_id'] = DecryptString($filter_docCategory);
		// }
		// if ($filter_subject != 0 || $filter_subject != '0') {
		//     $cond['ks.subject_id'] = DecryptString($filter_subject);
		// }
		// if ($filter_status != 0 || $filter_status != '0') {
		//     $cond['surat_status'] = DecryptString($filter_status);
		//     if ($this->sessionUserDetail['role_id'] == 4) {
		//         $cond['surat_status'] = 1;
		//     }
		// }
		$list = $this->letter->getList($cond);
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
			if ((in_array($this->data['menu_allow'] . '_validasi', $this->data['user_allow_menu'])) && ($field->surat_status == 2)) {

				$btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('letter/view/' . $field->surat_id . '/' . $field->user_id) . '" title="' . $this->lang->line('document_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
				$btnView2 = '<li>
                                    <a href="' . base_url('letter/view/' . $field->surat_id . '/' . $field->user_id) . '" class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('document_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
			}
			if ((in_array($this->data['menu_allow'] . '_view', $this->data['user_allow_menu'])) && ($field->surat_status == 1)) {
				$btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('letter/view/' . $field->surat_id . '/' . $field->user_id) . '" title="' . $this->lang->line('document_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
				$btnView2 = '<li>
                                    <a href="' . base_url('letter/view/' . $field->surat_id . '/' . $field->user_id) . '" class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('document_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
			}
			if ((in_array($this->data['menu_allow'] . '_view', $this->data['user_allow_menu'])) && ($this->sessionUserDetail['role_id'] == 1) && in_array($field->surat_status, array(1, 2, 4))) {
				$btnView = '<a class="blue tooltip-info" data-rel="tooltip" data-placement="bottom" href="' . base_url('letter/view/' . $field->surat_id . '/' . $field->user_id) . '" title="' . $this->lang->line('document_view') . '">
                            <i class="ace-icon fa fa-eye bigger-130"></i>
                        </a>';
				$btnView2 = '<li>
                                    <a href="' . base_url('letter/view/' . $field->surat_id . '/' . $field->user_id) . '" class="tooltip-info" data-rel="tooltip" title="' . $this->lang->line('document_view') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-eye bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
			}
			if (($field->surat_status == 3) && (in_array($this->data['menu_allow'] . '_upload', $this->data['user_allow_menu']))) {
				$label = 'info';
				$text = $this->lang->line('document_status_request');
				$btnUpload = '<a class="blue" data-rel="tooltip" data-placement="bottom" href="' . base_url('letter/upload/' . $field->surat_id . '/' . $field->user_id) . '" title="' . $this->lang->line('document_upload') . '">
                            <i class="ace-icon fa fa-upload bigger-130"></i>
                        </a>';
				$btnUpload2 = '<li>
                                    <a  href="' . base_url('letter/upload/' . $field->surat_id . '/' . $field->user_id) . '" class="tooltip-success" data-rel="tooltip" title="' . $this->lang->line('document_upload') . '">
                                        <span class="blue">
                                            <i class="ace-icon fa fa-upload bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
			} else if ($field->surat_status == 3) {
				$label = 'info';
				$text = $this->lang->line('document_status_request');
			}
			if ($field->surat_status == 4) {
				$label = 'danger';
				$text = $this->lang->line('document_status_reject');
				$hidden = "hidden";
			}
			if ($field->surat_status == 0) {
				$label = 'danger';
				$text = $this->lang->line('document_status_delete');
				$hidden = "hidden";
			}
			if ($field->surat_status == 1) {
				$label = 'success';
				$text = $this->lang->line('document_status_validated');
			}
			if ($field->surat_status == 2) {
				$label = 'warning';
				$text = $this->lang->line('document_status_waiting_valid');
			}

			if ((in_array($field->surat_status, array(2, 3))) && (in_array($this->data['menu_allow'] . '_edit', $this->data['user_allow_menu']))) {
				if (($this->session->userdata('logged_in')['role_id'] == 1) || ($field->user_id == $this->session->userdata('logged_in')['user_id'])) {

					$btnEdit = '<a class="green" data-rel="tooltip" data-placement="bottom" href="' . base_url('letter/edit/' . $field->surat_id . '/' . $field->user_id) . '" title="' . $this->lang->line('document_edit') . '">
                                    <i class="ace-icon fa fa-pencil bigger-130"></i>
                                </a>';
					$btnEdit2 = '<li>
                                    <a  href="' . base_url('letter/edit/' . $field->surat_id . '/' . $field->user_id) . '" class="tooltip-success" data-rel="tooltip" title="' . $this->lang->line('document_edit') . '">
                                        <span class="green">
                                            <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                        </span>
                                    </a>
                                </li>';
				}
			}
			if ((in_array($this->data['menu_allow'] . '_delete', $this->data['user_allow_menu']))) {
				$btnDelete = '<a class="red" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="approval(0,' . $field->surat_id . ', \'' . $field->user_id . '\')" title="' . $this->lang->line('document_delete') . '">
                            <i class="ace-icon fa fa-trash-o bigger-130"></i>
                        </a>';
				$btnDelete2 = '<li>
                                    <a href="javascript:;" onclick="approval(0,' . $field->surat_id . ', \'' . $field->user_id . '\')" class="tooltip-error" data-rel="tooltip" title="' . $this->lang->line('document_delete') . '">
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

			// $content = strlen($field->document_desc) > 50 ? substr($field->document_desc, 0, 50) . "..." : $field->document_desc;
			$status = '<span class="label label-sm label-' . $label . '">' . $text . '</span>';
			$suratDate = date("H:i:s d-m-Y", strtotime($field->surat_created_date));
			if ($field->surat_jenis == 1) {
				$jenis_surat = "Surat Masuk";
			} else if ($field->surat_jenis == 2) {
				$jenis_surat = "Surat Keluar";
			}
			// $row[] = $chkBox;
			$row[] = P($jenis_surat);
			$row[] = $field->user_email;
			$row[] = P($field->surat_nomor);
			$row[] = P($field->surat_asal);
			$row[] = P($field->surat_tujuan);
			$row[] = ($field->surat_keterangan);
			$row[] = P($suratDate);
			$row[] = $status;
			$row[] = $field->surat_tanggal_terima ? P($field->surat_tanggal_terima) : "-";
			$row[] = $btn;
			$data[] = $row;
		}

		$output = array(
			"draw"            => $_POST['draw'],
			"recordsTotal"    => $this->letter->count_new($cond),
			"recordsFiltered" => $this->letter->count_filtered_new($cond),
			"data"            => $data,
		);
		//output dalam format JSON

		echo json_encode($output);
	}

	public function upload()
	{
		$docId = $this->uri->segment(3);
		$docCode = $this->uri->segment(4);
		$doc_status = '(3)';
		$document = $this->letter->getOneDocument($docId, $docCode, $doc_status);

		$data = array(
			'title' => 'Upload Document',
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
				$this->template->load('default', 'letter/upload', $data);
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
		$docCode = $this->input->post('doc_code');
		$getUserRequest = $this->letter->getDocUser($insert_id, $docCode);
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
					$config['file_name'] = $insert_id . '_' . $docCode . '_' . $i;

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
						$dataUpload[$i]['surat_id'] = $insert_id;
						$dataUpload[$i]['user_id'] = $this->session->userdata('logged_in')['user_id'];
						$dataUpload[$i]['da_name'] = $filename;
						$dataUpload[$i]['da_dir'] = base_url('assets/uploads/letter/') . $filename;
						$dataUpload[$i]['da_created_date'] = date('Y-m-d H:i:s');
						$dataUpload[$i]['da_status'] = 1;
						// Initialize array
					}
				}
			}
			$this->db->trans_begin();
			$this->letter->inserAttachment($dataUpload);
			$dataDoc = array(
				'surat_status' => 2,
				'document_last_update' => date("Y-m-d H:i:s"),
				'document_last_update_by' => $this->session->userdata('logged_in')['user_id'],
			);
			$this->letter->updateDocument($insert_id, $dataDoc);
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
		$docId = $this->uri->segment(3);
		$userId = $this->uri->segment(4);
		$doc_status = '(1,2,4)';
		$document = $this->letter->getOneDocument($docId, $userId, $doc_status);
		$docAttachment = $this->letter->getOneDocumentAttachment($docId, $userId, $doc_status);

		$data = array(
			'title' => $this->lang->line('document_view'),
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'docDetail' => $document,
			'docAttachment' => $docAttachment,
			'menu_allow' => $this->data['menu_allow'],
			'user_allow_menu' => $this->data['user_allow_menu'],
			'system' => $this->system
		);
		if ($document) {
			if ($document[0]['surat_status'] == 4 && $this->sessionUserDetail['role_id'] == 1) {
				$this->template->load('default', 'letter/view', $data);
			} else if (in_array($document[0]['surat_status'], array(2)) && (in_array($this->data['menu_allow'] . '_validasi', $this->data['user_allow_menu']))) {
				$this->template->load('default', 'letter/view', $data);
			} else if (in_array($document[0]['surat_status'], array(1)) && (in_array($this->data['menu_allow'] . '_view', $this->data['user_allow_menu']))) {
				$this->template->load('default', 'letter/view', $data);
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
		$docId = $this->input->post('doc_id');
		$user_id = $this->input->post('doc_code');
		$data = array(
			'surat_status' => $status,
			'surat_modified_date' => date('Y-m-d H:i:s'),
			'surat_modified_by' => $this->session->userdata('logged_in')['user_id']
		);
		$approve = $this->letter->updateDocument($docId, $data);
		$docUser = $this->letter->getDocUser($docId, $user_id);
		if ($status == 1) {
			$approval = "Validated";
			$url = site_url("letter/view/$docId/$user_id");
			$msg = $this->lang->line('document_approval_valid');
		}
		if ($status == 4) {
			$approval = "Rejected";
			$url = site_url("letter/");
			$msg = $this->lang->line('document_approval_reject');
		}
		if ($status == 0) {
			$approval = "Deleted";
			$url = site_url("letter/");
			$msg = $this->lang->line('document_approval_delete');
		}
		if ($approve) {
			$res = array(
				'is_success' => true,
				'message' => $msg,
			);

			$approver = $this->sessionUserDetail['username'];
			$owner = $docUser['user_username'];
			$dataTemplate = array(
				'header' => "Notification",
				'text' => "Dear $owner,<br/><b> $approver </b> Has $approval your letter.",
				'btnText' => null,
				'btnLink' => null
			);
			$message = $this->load->view('template/mail', $dataTemplate, TRUE);
			if ($owner != $approver) {
				$this->load->helper('Mail_helper');
				sendMail($docUser['user_email'], 'Notification', $message, null, 'KMSchool');
				$dataNotif = array(
					'user_id' => $docUser['user_id'],
					'notif_subj' => 'uploaded',
					'notif_msg' =>  "<b>$approver</b> Has $approval your letter.",
					'notif_url' =>   $url,
					'notif_status' => 0,
					'notif_date' => date('Y-m-d H:i:s')
				);

				$this->db->insert('kms_notification', $dataNotif);
			}
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
		$docId = $this->uri->segment(3);
		$user_id = $this->uri->segment(4);
		$doc_status = '(2,3)';
		$document = $this->letter->getOneDocument($docId, $user_id, $doc_status);
		$docAttachment = $this->letter->getOneDocumentAttachment($docId, $user_id, $doc_status);
		$dataSchool = $this->filter->getSchools(1);
		$documentType = $this->filter->getDocumentType();
		$subjects = $this->filter->getSubjects();
		$data = array(
			'title' => "Edit Surat",
			'menu_body' => $this->menu_body,
			'usDetail' => $this->sessionUserDetail,
			'docDetail' => $document,
			'docAttachment' => $docAttachment,
			'system' => $this->system,
			'documentType' => $documentType,
			'subjects' =>   $subjects,
			'schools' =>   $dataSchool
		);
		if ((!in_array($this->data['menu_allow'] . '_upload', $this->data['user_allow_menu']))) {
			$res = array(
				'is_success' => false,
				'message' => $this->lang->line('warning_access'),
			);
			$this->template->load('default', '403', $data);
		} else {
			if ($document) {
				$this->template->load('default', 'letter/edit', $data);
			} else {
				$this->template->load('default', '404', $data);
			}
		}
	}

	public function saveEdit()
	{
		$docId = $this->input->post('surat_id');
		$doctype_id = $this->input->post('documentType');
		$subject_id = $this->input->post('subject');
		$docCode = $this->input->post('user_id');
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
		$updateDoc = $this->letter->updateDocument($docId, $data);
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
					$config['file_name'] = $docId . '_' . $docCode . '_' . $i;

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
						$dataUpload[$i]['surat_id'] = $docId;
						$dataUpload[$i]['user_id'] = $userId;
						$dataUpload[$i]['da_name'] = $filename;
						$dataUpload[$i]['da_dir'] = base_url('assets/uploads/letter/') . $filename;
						$dataUpload[$i]['da_created_date'] = date('Y-m-d H:i:s');
						$dataUpload[$i]['da_status'] = 1;
						// Initialize array
					}
				}
			}
			$insertAttachment = $this->letter->inserAttachment($dataUpload);
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
		$delete = $this->letter->deleteImg($id);
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
