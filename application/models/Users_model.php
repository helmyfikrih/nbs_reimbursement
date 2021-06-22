<?php

class Users_model extends CI_model
{

	var $column_order = array(
		'',
		'ud.user_f_name',
		'ud.user_id',
		'u.user_username',
		'ud.ud_address',
		'ur.role_name',
		'kdes.designation_name',
		'ks.school_name',
		'u.user_created_date',
		'u.user_status',
	);
	var $column_search = array(
		'',
		'ud.user_f_name',
		'ud.user_id',
		'u.user_username',
		'ud.ud_address',
		'ur.role_name',
		'kdes.designation_name',
		'ks.school_name',
		'u.user_created_date',
		'u.user_status',
	);

	var $order = array('user_id' => 'asc'); // default order


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

		$this->db->select('ud.*,u.user_username, u.user_status, u.user_created_date, ur.role_name, u.user_email, u.user_id as u_id
        ');
		$this->db->from('m_user u');
		$this->db->join('user_detail ud', 'u.user_id=ud.user_id', 'left');
		$this->db->join('m_role ur', 'ur.role_id=u.role_id', 'left');
		$this->db->join('kms_designation kdes', 'kdes.designation_id=ud.designation_id', 'left');
		// $this->db->join('kms_schools ks', 'ks.school_id=u.school_id', 'left');
		if ($cond) {
			$this->db->where($cond);
		}
		if ($this->session->userdata('logged_in')['role_id'] != 1) {
			$this->db->where('ks.school_id', $this->session->userdata('logged_in')['school_id']);
		}
		// $whereSess = "(bast.created_by_2w='$username' OR bast.created_by_4w='$username')";
		// $this->db->where($whereSess);

		$i = 0;

		foreach ($this->column_search as $item) // lojoining awal
		{
			if ($_POST['search']['value']) // jika datatable mengirimkan pencarian dengan metode POST
			{

				if ($i === 0) // lojoining awal
				{
					$this->db->group_start();
					$this->db->like($item, $_POST['search']['value']);
				} else {
					$this->db->or_like($item, $_POST['search']['value']);
				}

				if (count($this->column_search) - 1 == $i)
					$this->db->group_end();
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
		$this->db->select('ud.*,u.user_username, u.user_status, u.user_created_date, ur.role_name, kdes.designation_name, u.user_email, u.user_id as u_id
        ');
		$this->db->from('m_user u');
		$this->db->join('user_detail ud', 'u.user_id=ud.user_id', 'left');
		$this->db->join('m_role ur', 'ur.role_id=u.role_id', 'left');
		$this->db->join('kms_designation kdes', 'kdes.designation_id=ud.designation_id', 'left');
		// $this->db->join('kms_schools ks', 'ks.school_id=u.school_id', 'left');
		if ($cond) {
			$this->db->where($cond);
		}
		if ($this->session->userdata('logged_in')['role_id'] != 1) {
			$this->db->where('ks.school_id', $this->session->userdata('logged_in')['school_id']);
		}
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

	function sessionUserDetail()
	{
		$userId = $this->session->userdata('logged_in')['user_id'];
		$query = "SELECT 
                    u.user_id as uID, user_username, ud.*, kur.role_name, u.role_id, user_email
                  FROM 
                    m_user u 
                  LEFT JOIN 
                    user_detail ud ON ud.user_id=u.user_id 
                  LEFT JOIN 
                    m_role kur ON kur.role_id=u.role_id 
                  WHERE 
                    u.user_id='$userId'
        ";
		$res = $this->db->query($query)->result_array();
		$dataUser = array(
			'user_id' => $res[0]['uID'],
			'role_id' => $res[0]['role_id'],
			'username' => $res[0]['user_username'],
			'full_name' => $res[0]['user_f_name'],
			'role_name' => $res[0]['role_name'],
			'avatar_name' => 'avatar2.png',
		);
		return $dataUser;
	}

	function isExistusername($username)
	{

		$this->db->select('user_username');
		$this->db->from('m_user');
		//$this -> db -> where('username', $username);
		//$this -> db -> where('password', MD5($password));

		$this->db->where("user_username = '$username'", null, false);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	function isExistEmail($email)
	{

		$this->db->select('user_username');
		$this->db->from('m_user');
		//$this -> db -> where('username', $username);
		//$this -> db -> where('password', MD5($password));

		$this->db->where("user_email = '$email'", null, false);
		$this->db->limit(1);
		$query = $this->db->get();

		if ($query->num_rows() == 1) {
			return true;
		} else {
			return false;
		}
	}

	function insertUser($data)
	{
		return $this->db->insert('m_user', $data);
	}

	function updateUser($data, $cond)
	{
		$this->db->where($cond);
		return $this->db->update('m_user', $data);
	}

	function insertUserDetail($data)
	{
		return $this->db->insert('user_detail', $data);
	}

	function updateUserDetail($data, $cond)
	{
		$this->db->where($cond);
		return $this->db->update('user_detail', $data);
	}

	function getOneUser($userId, $username, $status)
	{
		$query = "SELECT 
                        ud.*, u.user_username, role_name, u.user_created_date, u.user_password, user_status, u.role_id, user_email, u.school_id
                    FROM 
                        m_user u 
                    LEFT JOIN 
                        user_detail ud ON ud.user_id =u.user_id
                    LEFT JOIN 
                        m_role role ON role.role_id =u.role_id
                    WHERE 
                        u.user_id = $userId AND u.user_username='$username' 
                    ";

		return $this->db->query($query)->result_array();
	}

	function getAllUserWithFilter($conds = null)
	{
		$this->db->select("*");
		$this->db->from("m_user");
		if ($conds) {
			$this->db->where($conds);
		}
		return $this->db->get()->result_array();
	}
}
