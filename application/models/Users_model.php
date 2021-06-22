<?php

class Users_model extends CI_model
{

  var $column_order = array(
    '',
    'ud.ud_full_name',
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
    'ud.ud_full_name',
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

    $this->db->select('ud.*,u.user_username, u.user_status, u.user_created_date, ur.role_name, kdes.designation_name, u.user_email, u.user_id as u_id, ks.school_name
        ');
    $this->db->from('kms_user u');
    $this->db->join('kms_user_detail ud', 'u.user_id=ud.user_id', 'left');
    $this->db->join('kms_user_role ur', 'ur.role_id=u.role_id', 'left');
    $this->db->join('kms_designation kdes', 'kdes.designation_id=ud.designation_id', 'left');
    $this->db->join('kms_schools ks', 'ks.school_id=u.school_id', 'left');
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
    $this->db->select('ud.*,u.user_username, u.user_status, u.user_created_date, ur.role_name, kdes.designation_name, u.user_email, u.user_id as u_id, ks.school_name
        ');
    $this->db->from('kms_user u');
    $this->db->join('kms_user_detail ud', 'u.user_id=ud.user_id', 'left');
    $this->db->join('kms_user_role ur', 'ur.role_id=u.role_id', 'left');
    $this->db->join('kms_designation kdes', 'kdes.designation_id=ud.designation_id', 'left');
    $this->db->join('kms_schools ks', 'ks.school_id=u.school_id', 'left');
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
                    u.user_id as uID, user_username, ud.*, kur.role_name, u.role_id,u.school_id, u.user_created_date, user_email, ks.school_name, ksub.subject_name
                  FROM 
                    kms_user u 
                  LEFT JOIN 
                    kms_user_detail ud ON ud.user_id=u.user_id 
                  LEFT JOIN 
                    kms_user_role kur ON kur.role_id=u.role_id 
                  LEFT JOIN 
                    kms_schools ks ON ks.school_id=u.school_id
                  LEFT JOIN 
                    kms_subject ksub ON ksub.subject_id=ud.subject_id  
                  WHERE 
                    u.user_id='$userId'
        ";
    $res = $this->db->query($query)->result_array();
    $dataUser = array(
      'user_id' => $res[0]['uID'],
      'school_id' => $res[0]['school_id'] ? $res[0]['school_id'] : 0,
      'school_name' => $res[0]['school_name'] ? $res[0]['school_name'] : 'all',
      'role_id' => $res[0]['role_id'],
      'subject_id' => $res[0]['subject_id'],
      'subject' => $res[0]['subject_name'],
      'username' => $res[0]['user_username'],
      'full_name' => $res[0]['ud_full_name'],
      'role_name' => $res[0]['role_name'],
      'birth_place' => $res[0]['ud_birth_place'],
      'birth_date' => $res[0]['ud_birth_date'],
      'nik' => $res[0]['ud_nik'],
      'sex' => $res[0]['ud_gender'],
      'address' => $res[0]['ud_address'],
      'phone' => $res[0]['ud_phone'],
      'email' => $res[0]['user_email'],
      'join_date' => $res[0]['user_created_date'],
      'avatar_name' => $res[0]['ud_img_name'] ? $res[0]['ud_img_name'] : 'avatar2.png',
    );
    return $dataUser;
  }

  function isExistusername($username)
  {

    $this->db->select('user_username');
    $this->db->from('kms_user');
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
    $this->db->from('kms_user');
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
    return $this->db->insert('kms_user', $data);
  }

  function updateUser($data, $cond)
  {
    $this->db->where($cond);
    return $this->db->update('kms_user', $data);
  }

  function insertUserDetail($data)
  {
    return $this->db->insert('kms_user_detail', $data);
  }

  function updateUserDetail($data, $cond)
  {
    $this->db->where($cond);
    return $this->db->update('kms_user_detail', $data);
  }

  function getOneUser($userId, $username, $status)
  {
    $query = "SELECT 
                        ud.*, u.user_username, role_name, u.user_created_date, u.user_password, user_status, u.role_id, ks.subject_name, kdes.designation_name, user_email, u.school_id, ksc.school_name
                    FROM 
                        kms_user u 
                    LEFT JOIN 
                        kms_user_detail ud ON ud.user_id =u.user_id
                    LEFT JOIN 
                        kms_user_role role ON role.role_id =u.role_id
                    LEFT JOIN 
                        kms_designation kdes ON kdes.designation_id =ud.designation_id
                    LEFT JOIN
                        kms_subject ks ON ks.subject_id =ud.subject_id
                    LEFT JOIN
                        kms_schools ksc ON ksc.school_id =ksc.school_id
                    WHERE 
                        u.user_id = $userId AND u.user_username='$username' 
                    ";

    return $this->db->query($query)->result_array();
  }

  function getAllUserWithFilter($conds = null)
  {
    $this->db->select("*");
    $this->db->from("kms_user");
    if ($conds) {
      $this->db->where($conds);
    }
    return $this->db->get()->result_array();
  }
}
