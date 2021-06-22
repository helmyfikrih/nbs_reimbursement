<?php

class Announcement_model extends CI_model
{

    var $column_order = array(
        // 'ka.announ_id',
        'ks.school_name',
        'ka.announ_number',
        'ka.announ_subject',
        'ka.announ_date',
        'ka.announ_title',
        'ka.announ_content',
        'ka.announ_created_date',
        'ku.user_username',
    );
    var $column_search = array(
        // 'ka.announ_id',
        'ks.school_name',
        'ka.announ_number',
        'ka.announ_subject',
        'ka.announ_date',
        'ka.announ_title',
        'ka.announ_content',
        'ka.announ_created_date',
        'ku.user_username',
    );

    var $order = array('announ_id' => 'asc'); // default order


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

        $this->db->select('ka.*, ks.school_name, ks.school_id, ku.user_username');
        $this->db->from('kms_announcement ka');
        $this->db->join('m_user ku', 'ku.user_id=ka.announ_created_by', 'left');
        $this->db->join('kms_schools ks', 'ks.school_id=ka.school_id', 'left');
        if ($cond) {
            $this->db->where($cond);
        }
        if ($this->session->userdata('logged_in')['role_id'] != 1) {
            $this->db->where('ks.school_id', $this->session->userdata('logged_in')['school_id']);
            $this->db->or_where('ks.school_id', null);
            $this->db->or_where('ks.school_id', '');
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
        $this->db->select('ka.*, ks.school_name, ks.school_id, ku.user_username');
        $this->db->from('kms_announcement ka');
        $this->db->join('m_user ku', 'ku.user_id=ka.announ_created_by', 'left');
        $this->db->join('kms_schools ks', 'ks.school_id=ka.school_id', 'left');
        if ($cond) {
            $this->db->where($cond);
        }
        if ($this->session->userdata('logged_in')['role_id'] != 1) {
            $this->db->where('ks.school_id', $this->session->userdata('logged_in')['school_id']);
            $this->db->or_where('ks.school_id', null);
            $this->db->or_where('ks.school_id', '');
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

    function insertAnnouncement($data)
    {
        return $this->db->insert('kms_announcement', $data);
    }

    function insertAttachment($data)
    {
        return $this->db->insert_batch('kms_announcement_attachment', $data);
    }

    function updatetAnnouncement($data, $cond)
    {
        $this->db->where($cond);
        return $this->db->update('kms_announcement', $data);
    }

    function getOneAnnoun($id)
    {
        $this->db->select('ka.*, ku.user_username, ks.school_name, ks.school_id, role_name');
        $this->db->from('kms_announcement ka');
        $this->db->join('m_user ku', 'ku.user_id=ka.announ_created_by', 'left');
        $this->db->join('m_role kur', 'kur.role_id=ku.role_id', 'left');
        $this->db->join('kms_schools ks', 'ks.school_id=ka.school_id', 'left');
        $this->db->where('ka.announ_id', $id);
        // $this->db->where('ka.announ_number', $number);
        $this->db->where('ka.announ_status', 1);
        return $this->db->get()->result_array();
    }

    function getOneAnnounAttachment($id)
    {
        $this->db->select('kaa.*');
        $this->db->from('kms_announcement ka');
        $this->db->join('kms_announcement_attachment kaa', 'kaa.announ_id=ka.announ_id', 'left');
        $this->db->where('ka.announ_id', $id);
        return $this->db->get()->result_array();
    }

    function getOneAnnounAttachmentByAttacId($id)
    {
        $this->db->select('kaa.*, ks.school_id');
        $this->db->from('kms_announcement_attachment kaa');
        $this->db->join('kms_announcement ka', 'ka.announ_id=kaa.announ_id');
        $this->db->join('m_user ku', 'ku.user_id=ka.announ_created_by');
        $this->db->join('kms_schools ks', 'ks.school_id=ku.school_id', 'left');
        $this->db->where('kaa.aa_id', $id);
        return $this->db->get()->result_array();
    }

    function getSchoolAnnoun($id)
    {
        $this->db->select('ks.school_id');
        $this->db->from('kms_announcement ka');
        $this->db->join('m_user ku', 'ku.user_id=ka.announ_created_by');
        $this->db->join('kms_schools ks', 'ks.school_id=ku.school_id', 'left');
        $this->db->where('ka.announ_id', $id);
        return $this->db->get()->result_array();
    }

    function deleteData($id)
    {
        $this->db->where('announ_id', $id);
        return $this->db->delete('kms_announcement');
    }

    function deleteAttach($id)
    {
        $this->db->where('aa_id', $id);
        return $this->db->delete('kms_announcement_attachment');
    }

    function getAllSubject()
    {
        return $this->db->get('kms_announcement')->result_array();
    }
}
