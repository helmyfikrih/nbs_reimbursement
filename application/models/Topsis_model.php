<?php

class Topsis_model extends CI_model
{

    var $column_order = array(
        'dr.code_region',
        'dr.name_region',
    );
    var $column_search = array(
        'dr.code_region',
        'dr.name_region',
    );

    // var $order = array('doctype_id' => 'asc'); // default order
    // var $order = array();

    function getList($cond = null, $table, $orderSearch)
    {
        $this->_get_datatables_query($cond, $table, $orderSearch);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    private function _get_datatables_query($cond, $table, $orderSearch)
    {

        $this->db->select('*');
        $this->db->from($table);
        if ($table == 'topsis_alternatif_kriteria tak') {
            $this->db->join('topsis_alternatif ta', 'ta.topsis_alternatif_id=tak.topsis_alternatif_id', 'left');
            $this->db->join('topsis_kriteria tk', 'tk.topsis_kriteria_id=tak.topsis_kriteria_id', 'left');
        }
        if ($table == 'topsis_hasil th') {
            $this->db->join('topsis_alternatif ta', 'ta.user_id=th.user_id', 'left');
            $order = array('th.ranking' => 'asc');
        }
        if ($cond) {
            $this->db->where($cond);
        }
        // $whereSess = "(bast.created_by_2w='$username' OR bast.created_by_4w='$username')";
        // $this->db->where($whereSess);

        $i = 0;

        foreach ($orderSearch as $item) // lojoining awal
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

                if (count($orderSearch) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($orderSearch[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($order)) {
            // $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    public function count_new($cond = null, $table, $orderSearch)
    {
        if ($cond) {
            $this->db->where($cond);
        }
        // $this->db->where(['bast.created_by_2w' => $username]);
        // $this->db->or_where(['bast.created_by_4w' => $username]);
        $this->db->select('*
        ');
        $this->db->from($table);
        return $this->db->count_all_results();
    }

    function count_filtered_new($cond = null, $table, $orderSearch)
    {
        $this->_get_datatables_query($cond, $table, $orderSearch);
        if ($cond) {
            $this->db->where($cond);
        }
        $query = $this->db->get();
        return $query->num_rows();
    }

    function getAltUser()
    {
        $this->db->select('user_id, user_username');
        $this->db->from('m_user');
        $this->db->where('user_status', 1);
        return $this->db->get()->result_array();
    }

    function syncAlt($data)
    {
        $q1 = "SET FOREIGN_KEY_CHECKS = 0; 
                ;";
        $q2 = "TRUNCATE TABLE topsis_alternatif;";
        $q3 = "SET FOREIGN_KEY_CHECKS = 1";
        $this->db->query($q1);
        $this->db->query($q2);
        $this->db->query($q3);
        return $this->db->insert_batch('topsis_alternatif', $data);
    }

    function inputAltKrit($data)
    {
        $q1 = "SET FOREIGN_KEY_CHECKS = 0; 
                ;";
        $q2 = "TRUNCATE TABLE topsis_alternatif_kriteria;";
        $q3 = "SET FOREIGN_KEY_CHECKS = 1";
        $this->db->query($q1);
        $this->db->query($q2);
        $this->db->query($q3);
        $this->db->query($q1);
        return $this->db->insert_batch('topsis_alternatif_kriteria', $data);
    }

    function addKriteria($data)
    {
        return $this->db->insert('topsis_kriteria', $data);
    }

    function updateKriteria($data, $cond)
    {
        $this->db->where($cond);
        return $this->db->update('topsis_kriteria', $data);
    }

    function getOneKriteria($id)
    {
        $this->db->where('topsis_kriteria_id', $id);
        return $this->db->get('topsis_kriteria')->result_array();
    }

    function getAlternatif()
    {
        return $this->db->get('topsis_alternatif')->result_array();
    }

    function getKriteria()
    {
        return $this->db->get('topsis_kriteria')->result_array();
    }

    function cUploadDocByAlt()
    {
        $q = "SELECT user_id, count(user_id) as nilai 
                FROM (
                    SELECT kda.user_id
                        FROM kms_document_attachment kda
                        JOIN kms_document kd ON kd.document_id=kda.document_id
                        WHERE document_status=1
                    GROUP BY kda.document_id
                ) doc
                GROUP  BY  user_id ";
        return $this->db->query($q)->result_array();
    }

    function cForumByAlt()
    {
        $q = "SELECT user_id, count(user_id) as nilai 
                FROM (
                    SELECT user_id
                        FROM kms_forum
                    GROUP BY forum_id
                ) doc 
                GROUP  BY  user_id ";
        return $this->db->query($q)->result_array();
    }

    function cForumReplyByAlt()
    {
        $q = "SELECT user_id, count(user_id) as nilai 
                FROM kms_forum_comment
              GROUP BY user_id";
        return $this->db->query($q)->result_array();
    }
}
