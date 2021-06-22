<?php

class Notification_model extends CI_model
{


    function getNewRegister()
    {
        $cond = array(
            'mandatory_approve' => 1,
            'approve_status IS NULl' => null
        );
        $this->db->where($cond);
        if ($this->session->userdata('logged_in')['role_id'] != 1) {
            $this->db->where('register_school_id', $this->session->userdata('logged_in')['school_id']);
        }
        return $this->db->get('m_user_register')->result_array();
    }

    function getRequestedDocument()
    {
        $cond = array(
            'kd.document_is_request' => 1,
            'kd.document_status' => 3
        );
        $this->db->select('kd.*, ku.user_username');
        $this->db->from('kms_document kd');
        $this->db->join('m_user ku', 'ku.user_id=kd.user_id', 'left');
        $this->db->where($cond);
        return $this->db->get()->result_array();
    }

    function getDocNeedApprove()
    {
        $cond = array(
            'kd.document_status' => 2
        );
        $this->db->select('kd.*, ku.user_username');
        $this->db->from('kms_document kd');
        $this->db->join('m_user ku', 'ku.user_id=kd.user_id', 'left');
        $this->db->where($cond);
        if ($this->session->userdata('logged_in')['role_id'] != 1) {
            $this->db->where('kd.school_id', $this->session->userdata('logged_in')['school_id']);
        }
        return $this->db->get()->result_array();
    }

    function getNoteNeedAction()
    {
        $cond = array(
            'kn.notulensi_status' => 2
        );
        $this->db->select('kn.*, ku.user_username');
        $this->db->from('kms_notulensi kn');
        $this->db->join('m_user ku', 'ku.user_id=kn.user_id', 'left');
        $this->db->join('kms_schools ks', 'ks.school_id=kn.school_id', 'left');
        $this->db->where($cond);
        if ($this->session->userdata('logged_in')['role_id'] != 1) {
            $this->db->where('ks.school_id', $this->session->userdata('logged_in')['school_id']);
        }
        return $this->db->get()->result_array();
    }

    function getNotification()
    {
        $this->db->select('*');
        $this->db->from('kms_notification');
        $this->db->where('user_id', $this->session->userdata('logged_in')['user_id']);
        $this->db->where('notif_status', 0);
        return $this->db->get()->result_array();
    }

    function setNotifReaded()
    {
        $data = array(
            'notif_status' => 1
        );
        $this->db->where('user_id', $this->session->userdata('logged_in')['user_id']);
        $this->db->where('notif_status', 0);
        $this->db->update('kms_notification', $data);
        return $this->db->affected_rows();
    }
}
