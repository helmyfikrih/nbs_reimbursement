<?php

class Notulensi_model extends CI_model
{
    var $column_order = array(
        'ks.school_name',
        'ku.user_username',
        'note.notulensi_code',
        'note.notulensi_agenda',
        'note.notulensi_content',
        'note.notulensi_date',
        'kmt.meetType_name',
        'note.notulensi_status',
    );
    var $column_search = array(
        'ks.school_name',
        'ku.user_username',
        'note.notulensi_code',
        'note.notulensi_agenda',
        'note.notulensi_content',
        'note.notulensi_date',
        'kmt.meetType_name',
        'note.notulensi_status',
    );

    var $order = array('notulensi_id' => 'asc'); // default order


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
        $this->db->from('kms_notulensi note');
        $this->db->join('kms_meeting_type kmt', 'kmt.meetType_id=note.meetType_id', 'left');
        $this->db->join('m_user ku', 'ku.user_id=note.user_id', 'left');
        $this->db->join('kms_schools ks', 'ks.school_id=note.school_id', 'left');
        if ($cond) {
            $this->db->where($cond);
        }
        if (($this->session->userdata('logged_in')['role_id'] != 1)) {
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
        $this->db->select('*
        ');
        $this->db->from('kms_notulensi note');
        $this->db->join('kms_meeting_type kmt', 'kmt.meetType_id=note.meetType_id', 'left');
        $this->db->join('m_user ku', 'ku.user_id=note.user_id', 'left');
        $this->db->join('kms_schools ks', 'ks.school_id=note.school_id', 'left');
        if ($cond) {
            $this->db->where($cond);
        }
        if (($this->session->userdata('logged_in')['role_id'] != 1)) {
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

    function insertNotulensi($data)
    {
        return $this->db->insert('kms_notulensi', $data);
    }

    function updateNotulensi($data, $id)
    {
        $this->db->where('notulensi_id', $id);
        return $this->db->update('kms_notulensi', $data);
    }

    function inserAttachment($data)
    {
        return $this->db->insert_batch('kms_notulensi_attachment', $data);
    }

    function getOneNotulensi($notulensiId, $notulensiCode)
    {
        $this->db->select('kn.*, ku.user_username, kur.role_name, kmt.meetType_name, ks.school_name');
        $this->db->from('kms_notulensi kn');
        $this->db->join('m_user ku', 'ku.user_id=kn.user_id', 'left');
        $this->db->join('kms_schools ks', 'ks.school_id=kn.school_id', 'left');
        $this->db->join('user_detail kud', 'kud.user_id=ku.user_id', 'left');
        $this->db->join('m_role kur', 'kur.role_id=ku.role_id', 'left');
        $this->db->join('kms_meeting_type kmt', 'kmt.meetType_id=kn.meetType_id', 'left');
        $this->db->where('kn.notulensi_id', $notulensiId);
        $this->db->where('kn.notulensi_code', $notulensiCode);
        $this->db->where('kn.notulensi_status !=', 0);
        if (($this->session->userdata('logged_in')['role_id'] != 1)) {
            $this->db->where('ks.school_id', $this->session->userdata('logged_in')['school_id']);
        }
        return $this->db->get()->result_array();
    }

    function getOneNotulensiAttachment($notulensiId)
    {
        $this->db->select('*');
        $this->db->from('kms_notulensi_attachment');
        $this->db->where('notulensi_id', $notulensiId);
        return $this->db->get()->result_array();
    }

    function approval($data, $notulensiId)
    {
        $this->db->where('notulensi_id', $notulensiId);
        return $this->db->update('kms_notulensi', $data);
    }

    function deleteImg($id)
    {
        $this->db->where('na_id', $id);
        return $this->db->delete('kms_notulensi_attachment');
    }

    function getType()
    {
        return $this->db->get('kms_meeting_type')->result_array();
    }
}
