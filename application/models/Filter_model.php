<?php

class Filter_model extends CI_model
{


    function getSchools($filter_role = null)
    {
        $this->db->where('school_status', 1);
        if ($filter_role) {
            if ($this->session->userdata('logged_in')['role_id'] != 1) {
                $this->db->where('school_id', $this->session->userdata('logged_in')['school_id']);
            }
        }
        return $this->db->get('kms_schools')->result_array();
    }

    function getMeetType()
    {
        return $this->db->get('kms_meeting_type')->result_array();
    }

    function getDocumentType()
    {
        return $this->db->get('kms_document_type')->result_array();
    }

    function getSubjects()
    {
        return $this->db->get('kms_subject')->result_array();
    }

    function getDocCategory()
    {
        return $this->db->get('kms_document_type')->result_array();
    }

    function getForumCategory()
    {
        return $this->db->select('forum_category')->get('kms_forum')->result_array();
    }
}
