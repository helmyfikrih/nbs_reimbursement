<?php

class Reimburse_model extends CI_model
{

	var $column_order = array(
		'ku.user_username',
		'kd.reimburse_created_at',
		'kd.reimburse_value',
		'kd.reimburse_status',
	);
	var $column_search = array(
		'ku.user_username',
		'kd.reimburse_created_at',
		'kd.reimburse_value',
		'kd.reimburse_status',
	);

	var $order = array('reimburse_id' => 'asc'); // default order


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

		$this->db->select('kd.*, ku.user_username, kdt.reimburse_type_name, ud.*, kd.user_id as user_id
        ');
		$this->db->from('reimburse kd');
		$this->db->join('m_user ku', 'ku.user_id=kd.user_id', 'left');
		$this->db->join('user_detail ud', 'ud.user_id=kd.user_id', 'left');
		$this->db->join('m_reimburse_type kdt', 'kdt.reimburse_type_id=kd.reimburse_type_id', 'left');
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
					$this->db->or_like('kd.document_status', 1);
				} else if ((strpos($src, 'rej') !== false) || (strpos($src, 're') !== false) || (strpos($src, 'r') !== false)) {
					$this->db->or_like('kd.document_status', 4);
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
		$this->db->select('*
        ');
		$this->db->from('reimburse kd');
		$this->db->join('m_user ku', 'ku.user_id=kd.user_id', 'left');
		$this->db->join('m_reimburse_type kdt', 'kdt.reimburse_type_id=kd.reimburse_type_id', 'left');
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

	public function insertReimburse($data)
	{
		return $this->db->insert('reimburse', $data);
	}

	function inserAttachment($data)
	{
		return $this->db->insert_batch('reimburse_attachment', $data);
	}

	function getOneReimburse($cond)
	{
		$this->db->select(' kd.*, count(kda.reimburse_id) AS reimburse_count, ku.user_username, kdt.reimburse_type_name');
		$this->db->from('reimburse kd ');
		$this->db->join('m_reimburse_type kdt', 'kdt.reimburse_type_id =kd.reimburse_type_id', 'left');
		$this->db->join('reimburse_attachment kda', 'kda.reimburse_id =kd.reimburse_id', 'left');
		$this->db->join('m_user ku', 'ku.user_id=kd.user_id', 'left');
		$this->db->join('user_detail kud', 'kud.user_id=ku.user_id', 'left');
		$this->db->group_by("kd.reimburse_id");
		if ($cond) {
			$this->db->where($cond);
		}
		return $this->db->get()->result_array();
	}

	function getOneReimburseAttachment($reimburseId)
	{
		$this->db->select('kda.*, ku.user_username');
		$this->db->from('reimburse_attachment kda');
		$this->db->join('m_user ku', 'ku.user_id=kda.user_id', 'left');
		$this->db->where('reimburse_id', $reimburseId);
		return $this->db->get()->result_array();
	}

	function getOneReimburseApprovalManagement($id)
	{

		$query = "SELECT um2.*, mu.*, ra.* FROM
				reimburse r 
				LEFT JOIN 
					users_managerial um ON um.user_id = r.user_id 
				LEFT JOIN 
					user_manager um2 ON um2.user_manager_id = um.user_manager_id 
				LEFT JOIN 
					m_user mu ON mu.user_id = um2.user_id 
				LEFT JOIN 
					reimburse_approval ra ON ra.reimburse_id = r.reimburse_id 
				WHERE r.reimburse_id = $id";
		return $this->db->query($query)->result_array();
	}

	function updateReimburse($reimburseId, $data)
	{
		$this->db->where('reimburse_id', $reimburseId);
		return $this->db->update('reimburse', $data);
	}

	function deleteImg($id)
	{
		$this->db->where('reimburse_attachment_id', $id);
		return $this->db->delete('reimburse_attachment');
	}

	function getReimburseUser($reimburseId, $docCode = null)
	{
		$query = "SELECT 
                        kd.*, ku.*
                    FROM 
                        reimburse kd 
                    LEFT JOIN 
                        m_user ku ON ku.user_id=kd.user_id
                    LEFT JOIN 
                        user_detail kud ON kud.user_id=ku.user_id
                    WHERE 
                        kd.reimburse_id = $reimburseId AND kd.document_code='$docCode'";
		$res = $this->db->query($query)->result_array();
		$data = array();
		foreach ($res as $row) {
			$data = $row;
		}
		return $data;
	}
}
