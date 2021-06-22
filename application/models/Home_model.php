<?php

class Home_model extends CI_model
{

	function getDocument()
	{
		$this->db->select('*');
		$this->db->order_by('document_created_date', 'DESC');
		return $this->db->get('kms_document')->result_array();
	}

	function getForum()
	{
		$this->db->select('kf.*, kud.ud_img_name');
		$this->db->from('kms_forum kf');
		$this->db->join('user_detail kud', 'kud.user_id=kf.user_id', 'left');
		$this->db->order_by('forum_created_date', 'DESC');
		return $this->db->get()->result_array();
	}

	function getForumComment()
	{
		$this->db->select('kfc.*, ku.user_username, kud.ud_img_name, kf.forum_slug');
		$this->db->from('kms_forum_comment kfc');
		$this->db->join('kms_forum kf', 'kf.forum_id=kfc.forum_id', 'left');
		$this->db->join('m_user ku', 'ku.user_id=kfc.user_id', 'left');
		$this->db->join('user_detail kud', 'kud.user_id=ku.user_id', 'left');
		$this->db->order_by('fc_created_date', 'DESC');
		return $this->db->get()->result_array();
	}

	function getNotulensi()
	{
		$this->db->select('*');
		$this->db->order_by('notulensi_created_date', 'DESC');
		return $this->db->get('kms_notulensi')->result_array();
	}

	function getUsers()
	{
		$this->db->select('ku.*, kud.ud_img_name, kur.role_name');
		$this->db->from('m_user ku');
		// $this->db->join('kms_schools ksc', 'ksc.school_id=ku.school_id', 'left');
		$this->db->join('user_detail kud', 'kud.user_id=ku.user_id', 'left');
		$this->db->join('m_role kur', 'kur.role_id=ku.role_id', 'left');
		$this->db->order_by('ku.user_id', 'DESC');
		return $this->db->get()->result_array();
	}

	function getAnnouncement()
	{
		$this->db->where('announ_status', 1);
		if ($this->session->userdata('logged_in')['role_id'] != 1) {
			$this->db->where('school_id', $this->session->userdata('logged_in')['school_id']);
			$this->db->or_where('school_id', null);
			$this->db->or_where('school_id', '');
		}
		$this->db->order_by('school_id', 'desc');
		$this->db->limit(2);
		return $this->db->get('kms_announcement')->result_array();
	}

	function getDocumentAttch()
	{
		$this->db->select('kda.*');
		$this->db->from('kms_document_attachment kda');
		$this->db->join('kms_document kd', 'kd.document_id=kda.document_id', 'left');
		$this->db->where('kd.document_status', 1);
		return $this->db->get('kms_document_attachment')->result_array();
	}

	function insertSearchLog($q)
	{
		$data = array(
			'user_id' => $this->session->userdata('logged_in')['user_id'],
			'ls_keyword' => $q,
			'ls_date' => date("Y-m-d H:i:s")
		);
		$this->db->insert('kms_log_search', $data);
	}

	function search($q)
	{
		$query = "SELECT 
                        kd.document_id AS id, 
                        'document' AS 'from',
                        kd.document_code  AS code,
                        kd.document_name  AS title, 
                        kd.document_desc AS 'desc'  
                    FROM 
                        kms_document kd
                    WHERE 
                        (document_code LIKE '%$q%' OR document_name LIKE '%$q%')
                    UNION
                    SELECT 
                        kf.forum_id AS id,
                        'forum' AS 'from', 
                        kf.forum_slug AS code,
                        kf.forum_title AS title,
                        kf.forum_content AS 'desc'
                    FROM kms_forum kf 
                    WHERE (forum_title LIKE '%$q%')";
		return $this->db->query($query)->result_array();
	}

	// Fetch records
	function getSearchList($rowno, $rowperpage, $q)
	{
		$query = "SELECT 
                        kd.document_id AS id, 
                        'document' AS 'from',
                        kd.document_code  AS code,
                        kd.document_name  AS title, 
                        kd.document_desc AS 'desc',  
                        ku.user_username AS username,
                        kd.document_created_date AS date
                    FROM 
                        kms_document kd
                   	LEFT JOIN 
                       m_user ku ON ku.user_id=kd.user_id  
                    WHERE 
                        (document_code LIKE '%$q%' OR document_name LIKE '%$q%')
                        AND document_status = 1
                    UNION
                    SELECT 
                        kf.forum_id AS id,
                        'forum' AS 'from', 
                        kf.forum_slug AS code,
                        kf.forum_title AS title,
                        kf.forum_content AS 'desc',
                        ku.user_username AS username,
                        kf.forum_created_date AS date
                    FROM 
                        kms_forum kf 
                    LEFT JOIN 
                        m_user ku ON ku.user_id=kf.user_id
                    WHERE 
                        (forum_title LIKE '%$q%') 
                        AND forum_status=1
                    ORDER BY title ASC
                    LIMIT $rowno, $rowperpage";
		return $this->db->query($query)->result_array();
	}

	// Select total records
	public function getSearchListCount($q)
	{

		$query = "SELECT count(id) AS allcount FROM (SELECT 
                        kd.document_id AS id, 
                        'document' AS 'from',
                        kd.document_code  AS code,
                        kd.document_name  AS title, 
                        kd.document_desc AS 'desc'  
                    FROM 
                        kms_document kd
                    WHERE 
                        (document_code LIKE '%$q%' OR document_name LIKE '%$q%') 
                        AND document_status = 1
                    UNION
                    SELECT 
                        kf.forum_id AS id,
                        'forum' AS 'from', 
                        kf.forum_slug AS code,
                        kf.forum_title AS title,
                        kf.forum_content AS 'desc'
                    FROM 
                        kms_forum kf 
                    WHERE 
                        (forum_title LIKE '%$q%')
                        AND forum_status=1 
                    ) AS SEARCH";
		$result = $this->db->query($query)->result_array();
		return $result[0]['allcount'];
	}
}
