<?php

class Forum_model extends CI_model
{

    function insert($params)
    {
        $data = array(
            'user_id' => $this->session->userdata('logged_in')['user_id'],
            'forum_title' => $params['post_title'],
            'forum_slug' => url_title($params['post_title'], 'dash', true),
            'forum_content' => $params['post_content'],
            'forum_category' => $params['post_category'],
            'forum_created_date' => date('Y-m-d H:i:s'),
            'forum_status' => 1,

        );

        return $this->db->insert('kms_forum', $data);
    }

    function update($cond, $data)
    {
        $this->db->where($cond);
        return $this->db->update('kms_forum', $data);
    }

    // Fetch records
    function getDataList($rowno, $rowperpage)
    {
        $this->db->select('kf.*,kud.ud_img_name, ku.user_username, ksc.school_name');
        $this->db->from('kms_forum kf');
        $this->db->join('m_user ku', 'ku.user_id=kf.user_id', 'left');
        $this->db->join('kms_schools ksc', 'ku.school_id=ksc.school_id', 'left');
        $this->db->join('user_detail kud', 'ku.user_id=kud.user_id', 'left');
        $saerchText = $this->input->post('saerchText');
        $tag = $this->input->post('tag');
        $where = "kf.forum_title LIKE '%$saerchText%' OR ku.user_username LIKE '%$saerchText%' OR kf.forum_category LIKE '%$saerchText%'";
        if ($saerchText !== '') {
            $this->db->where($where);
        }
        if ($tag != '') {
            $this->db->where("kf.forum_category LIKE '%$tag%'");
        }
        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();

        return $query->result_array();
    }

    // Select total records
    public function getDataListCount()
    {

        $this->db->select('count(*) as allcount');
        $this->db->from('kms_forum kf');
        $this->db->join('m_user ku', 'ku.user_id=kf.user_id', 'left');
        $saerchText = $this->input->post('saerchText');
        $tag = $this->input->post('tag');
        $where = "kf.forum_title LIKE '%$saerchText%' OR ku.user_username LIKE '%$saerchText%' OR kf.forum_category LIKE '%$saerchText%'";
        if ($saerchText !== '') {
            $this->db->where($where);
        }
        if ($tag != '') {
            $this->db->where("kf.forum_category LIKE '$tag'");
        }
        $query = $this->db->get();
        $result = $query->result_array();

        return $result[0]['allcount'];
    }

    public function getSingleForum($forum_id, $forum_slug)
    {
        $query = "  SELECT 
                        kf.*, ku.user_username,ku.user_email, kud.ud_img_name, kur.role_name, ksc.school_name
                    FROM 
                        kms_forum kf
                    LEFT JOIN m_user ku ON ku.user_id=kf.user_id
                    LEFT JOIN kms_schools ksc ON ku.school_id=ksc.school_id
                    LEFT JOIN user_detail kud On kud.user_id=ku.user_id
                    LEFT JOIN m_role kur On kur.role_id=ku.role_id
                    WHERE 
                        forum_id=$forum_id AND forum_slug='$forum_slug'";
        return $this->db->query($query)->result_array();
    }

    public function insertComment($forumId, $fcContent)
    {
        $data = array(
            'forum_id' => $forumId,
            'user_id' => $this->session->userdata('logged_in')['user_id'],
            'fc_status' => 1,
            'fc_content' => $fcContent,
            'fc_created_date' => date('Y-m-d H:i:s')
        );

        return $this->db->insert('kms_forum_comment', $data);
    }

    // Fetch records
    function getDataCommentList($rowno, $rowperpage, $forumId)
    {
        $this->db->select('kfc.*, ku.user_username, kud.ud_img_name, kfc.user_id, kur.role_name, ifnull(ksc.school_name, "-") as school_name');
        $this->db->from('kms_forum_comment kfc');
        $this->db->join('m_user ku', 'ku.user_id=kfc.user_id', 'left');
        $this->db->join('kms_schools ksc', 'ksc.school_id=ku.school_id', 'left');
        $this->db->join('user_detail kud', 'ku.user_id=kud.user_id', 'left');
        $this->db->join('m_role kur', 'kur.role_id=ku.role_id', 'left');
        $this->db->where('forum_id', $forumId);
        $this->db->order_by('kfc.fc_created_date', 'ASC');
        $this->db->limit($rowperpage, $rowno);
        $query = $this->db->get();

        return $query->result_array();
    }

    // Select total records
    function getDataCommentCount($forumId)
    {

        $this->db->select('count(*) as allcount');
        $this->db->from('kms_forum_comment');
        $this->db->where('forum_id', $forumId);
        $query = $this->db->get();
        $result = $query->result_array();

        return $result[0]['allcount'];
    }

    function deleteComment($commentId)
    {
        $this->db->where('fc_id', $commentId);
        return $this->db->delete('kms_forum_comment');
    }

    function getOneDocument($conds)
    {
    }
}
