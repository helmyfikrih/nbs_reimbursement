<?php

class Subject_model extends CI_model
{

    var $column_order = array(
        'subject_id',
        'subject_code',
        'subject_name',
    );
    var $column_search = array(
        'subject_id',
        'subject_code',
        'subject_name',
    );

    var $order = array('subject_id' => 'asc'); // default order


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

        $this->db->select('*');
        $this->db->from('kms_subject');
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
        $this->db->select('*
        ');
        $this->db->from('kms_subject');
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

    function insertSubject($data)
    {
        return $this->db->insert('kms_subject', $data);
    }

    function updatetSubject($data, $cond)
    {
        $this->db->where($cond);
        return $this->db->update('kms_subject', $data);
    }

    function getOne($id)
    {
        $this->db->where('subject_id', $id);
        return $this->db->get('kms_subject')->result_array();
    }

    function deleteData($id)
    {
        $this->db->where('subject_id', $id);
        return $this->db->delete('kms_subject');
    }

    function getAllSubject()
    {
        return $this->db->get('kms_subject')->result_array();
    }
}
