<?php

class Document_model extends CI_model
{

    var $column_order = array(
        'kd.document_code',
        'kd.document_name',
        'kd.document_desc',
        'kdt.doctype_name',
        'ks.subject_name',
        'ku.user_username',
        'kd.document_created_date',
        'kd.document_status',
    );
    var $column_search = array(
        'kd.document_code',
        'kd.document_name',
        'kd.document_desc',
        'kdt.doctype_name',
        'ks.subject_name',
        'ku.user_username',
        'kd.document_created_date',
        'kd.document_status',
    );

    var $order = array('document_id' => 'asc'); // default order


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

        $this->db->select('kd.*, ku.user_username, kdt.doctype_name, ks.subject_name, ksc.school_name
        ');
        $this->db->from('kms_document kd');
        $this->db->join('m_user ku', 'ku.user_id=kd.user_id', 'left');
        $this->db->join('kms_schools ksc', 'kd.school_id=ksc.school_id', 'left');
        $this->db->join('kms_subject ks', 'ks.subject_id=kd.subject_id', 'left');
        $this->db->join('kms_document_type kdt', 'kdt.doctype_id=kd.doctype_id', 'left');
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
        $this->db->from('kms_document kd');
        $this->db->join('m_user ku', 'ku.user_id=kd.user_id', 'left');
        $this->db->join('kms_schools ksc', 'kd.school_id=ksc.school_id', 'left');
        $this->db->join('kms_subject ks', 'ks.subject_id=kd.subject_id', 'left');
        $this->db->join('kms_document_type kdt', 'kdt.doctype_id=kd.doctype_id', 'left');
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
        return $this->db->insert('kms_document', $data);
    }

    function inserAttachment($data)
    {
        return $this->db->insert_batch('kms_document_attachment', $data);
    }

    function getOneDocument($docId, $docCode, $docStatus)
    {
        $query = "SELECT 
                        kd.*, count(kda.document_id) AS document_count, ku.user_username, kud.ud_img_name, ks.subject_name, kdt.doctype_name, ksc.school_name
                    FROM 
                        kms_document kd 
                    LEFT JOIN 
                        kms_document_attachment kda ON kda.document_id =kd.document_id
                    LEFT JOIN 
                        m_user ku ON ku.user_id=kd.user_id
                    LEFT JOIN 
                        kms_schools ksc ON kd.school_id=ksc.school_id
                    LEFT JOIN 
                        user_detail kud ON kud.user_id=ku.user_id
                    LEFT JOIN 
                        kms_document_type kdt ON kdt.doctype_id = kd.doctype_id
                    LEFT JOIN 
                        kms_subject ks ON ks.subject_id = kd.subject_id
                    WHERE 
                        kd.document_id = $docId AND kd.document_code='$docCode' AND kd.document_status IN $docStatus
                    GROUP  BY 
                        kd.document_id";

        return $this->db->query($query)->result_array();
    }

    function getOneDocumentAttachment($docId)
    {
        $this->db->select('kda.*, ku.user_username');
        $this->db->from('kms_document_attachment kda');
        $this->db->join('m_user ku', 'ku.user_id=kda.user_id', 'left');
        $this->db->where('document_id', $docId);
        return $this->db->get()->result_array();
    }

    function updateDocument($docId, $data)
    {
        $this->db->where('document_id', $docId);
        return $this->db->update('kms_document', $data);
    }

    function deleteImg($id)
    {
        $this->db->where('da_id', $id);
        return $this->db->delete('kms_document_attachment');
    }

    function getDocUser($docId, $docCode)
    {
        $query = "SELECT 
                        kd.*, ku.*
                    FROM 
                        kms_document kd 
                    LEFT JOIN 
                        m_user ku ON ku.user_id=kd.user_id
                    LEFT JOIN 
                        user_detail kud ON kud.user_id=ku.user_id
                    WHERE 
                        kd.document_id = $docId AND kd.document_code='$docCode'";
        $res = $this->db->query($query)->result_array();
        $data = array();
        foreach ($res as $row) {
            $data = $row;
        }
        return $data;
    }
}
