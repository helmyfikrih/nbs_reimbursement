<?php

class Register_user_model extends CI_model
{

    var $column_order = array(
        'dr.code_region',
        'dr.name_region',
    );
    var $column_search = array(
        'dr.code_region',
        'dr.name_region',
    );

    var $order = array('register_id' => 'asc'); // default order


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

        $this->db->select('reg.*, ur.*, ks.*
        ');
        $this->db->from('m_user_register reg');
        $this->db->join('m_role ur', 'ur.role_id=reg.register_role', 'left');
        $this->db->join('kms_schools ks', 'ks.school_id=reg.register_school_id', 'left');
        if ($cond) {
            $this->db->where($cond);
        }
        // $whereSess = "(bast.created_by_2w='$username' OR bast.created_by_4w='$username')";
        // $this->db->where($whereSess);
        if ($this->session->userdata('logged_in')['role_id'] != 1) {
            $this->db->where('ks.school_id', $this->session->userdata('logged_in')['school_id']);
        }
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
        if ($cond) {
            $this->db->where($cond);
        }
        // $this->db->where(['bast.created_by_2w' => $username]);
        // $this->db->or_where(['bast.created_by_4w' => $username]);
        $this->db->select('reg.*, ur.*
        ');
        $this->db->from('m_user_register reg');
        $this->db->join('m_role ur', 'ur.role_id=reg.register_role', 'left');
        $this->db->join('kms_schools ks', 'ks.school_id=reg.register_school_id', 'left');
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

    function getData($cond)
    {
        $this->db->where($cond);
        return $this->db->get('m_user_register')->result_array();
    }

    function update($data, $cond)
    {
        $this->db->where($cond);
        return $this->db->update('m_user_register', $data);
    }

    function insertUser($data)
    {
        return $this->db->insert('m_user', $data);
    }

    function insertUserDetail($data)
    {
        return $this->db->insert('user_detail', $data);
    }
}
