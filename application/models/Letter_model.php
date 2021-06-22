<?php

class Letter_model extends CI_model
{

	var $column_order = array(
		'ks.surat_jenis',
		'ku.user_email',
		'ks.surat_nomor',
		'ks.surat_asal',
		'ks.surat_tujuan',
		'ks.surat_keterangan',
		'ks.surat_created_date',
		'ks.surat_status',
		'ks.surat_tanggal_terima',
	);
	var $column_search = array(
		'ks.surat_jenis',
		'ku.user_email',
		'ks.surat_nomor',
		'ks.surat_asal',
		'ks.surat_tujuan',
		'ks.surat_keterangan',
		'ks.surat_created_date',
		'ks.surat_status',
		'ks.surat_tanggal_terima',
	);

	var $order = array('surat_id' => 'asc'); // default order


	function getList($cond = null)
	{
		$this->_get_datatables_query($cond);
		if ($_POST['length'] != -1)
			$this->db->limit($_POST['length'], $_POST['start']);
		$query = $this->db->get();
		return $query->result();
	}

	private function _get_datatables_query($cond)
	{

		$this->db->select('ks.*, ku.user_username, ku.user_email');
		$this->db->from('kms_surat ks');
		$this->db->join('kms_user ku', 'ku.user_id=ks.user_id', 'left');
		if ($cond) {
			$this->db->where($cond);
		}
		// $whereSess = "(bast.created_by_2w='$username' OR bast.created_by_4w='$username')";
		// $this->db->where($whereSess);

		$i = 0;

		foreach ($this->column_search as $item) // lojoining awal
		{
			if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
			{

				if ($i === 0) // joining awal
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
				$src = $_POST['search']['value'];
				if ((strpos($src, 'val') !== false) || (strpos($src, 'va') !== false) || (strpos($src, 'v') !== false)) {
					$this->db->or_like('ks.surat_status', 1);
				} else if ((strpos($src, 'rej') !== false) || (strpos($src, 're') !== false) || (strpos($src, 'r') !== false)) {
					$this->db->or_like('ks.surat_status', 4);
				}
			}
			$i++;
		}

		if (isset($_POST['order'])) {
			$this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
		} else if (isset($this->order)) {
			$order = $this->order;
			$this->db->order_by(key($order), $order[key($order)]);
		}
	}

	public function count_new($cond = null)
	{
		if ($cond) {
			$this->db->where($cond);
		}
		// $this->db->where(['bast.created_by_2w' => $username]);
		// $this->db->or_where(['bast.created_by_4w' => $username]);
		$this->db->select('ks.*, ku.user_username');
		$this->db->from('kms_surat ks');
		$this->db->join('kms_user ku', 'ku.user_id=ks.user_id', 'left');
		return $this->db->count_all_results();
	}

	function count_filtered_new($cond = null)
	{
		$this->_get_datatables_query($cond);
		if ($cond) {
			$this->db->where($cond);
		}
		$query = $this->db->get();
		return $query->num_rows();
	}

	public function insertDocument($data)
	{
		return $this->db->insert('kms_surat', $data);
	}

	function inserAttachment($data)
	{
		return $this->db->insert_batch('kms_surat_attachment', $data);
	}

	function getOneDocument($docId, $userId, $docStatus)
	{
		$query = "SELECT 
                        ks.*, count(ksa.surat_id) AS document_count, ku.user_username, kud.ud_img_name, ksc.school_name
                    FROM 
                        kms_surat ks 
                    LEFT JOIN 
                        kms_surat_attachment ksa ON ksa.surat_id =ks.surat_id
                    LEFT JOIN 
                        kms_user ku ON ku.user_id=ks.user_id
                    LEFT JOIN 
                        kms_schools ksc ON ku.school_id=ksc.school_id
                    LEFT JOIN 
                        kms_user_detail kud ON kud.user_id=ku.user_id
                    WHERE 
                        ks.surat_id = $docId AND ks.user_id='$userId' AND ks.surat_status IN $docStatus
                    GROUP  BY 
                        ks.surat_id";

		return $this->db->query($query)->result_array();
	}

	function getOneDocumentAttachment($docId)
	{
		$this->db->select('ksa.*, ku.user_username');
		$this->db->from('kms_surat_attachment ksa');
		$this->db->join('kms_user ku', 'ku.user_id=ksa.user_id', 'left');
		$this->db->where('surat_id', $docId);
		return $this->db->get()->result_array();
	}

	function updateDocument($docId, $data)
	{
		$this->db->where('surat_id', $docId);
		return $this->db->update('kms_surat', $data);
	}

	function deleteImg($id)
	{
		$this->db->where('sa_id', $id);
		return $this->db->delete('kms_surat_attachment');
	}

	function getDocUser($docId, $user_id)
	{
		$query = "SELECT 
                        ks.*, ku.*
                    FROM 
                        kms_surat ks 
                    LEFT JOIN 
                        kms_user ku ON ku.user_id=ks.user_id
                    LEFT JOIN 
                        kms_user_detail kud ON kud.user_id=ku.user_id
                    WHERE 
                        ks.surat_id = $docId AND ks.user_id='$user_id'";
		$res = $this->db->query($query)->result_array();
		$data = array();
		foreach ($res as $row) {
			$data = $row;
		}
		return $data;
	}
}
