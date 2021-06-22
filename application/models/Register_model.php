<?php

class Register_model extends CI_model
{

    function getData($cond)
    {
        $this->db->where($cond);
        return $this->db->get('m_user_register')->result_array();
    }

    function insertRegister($data)
    {
        return $this->db->insert('m_user_register', $data);
    }

    function insertUser($data)
    {
        return $this->db->insert('m_user', $data);
    }

    function insertUserDetail($data)
    {
        return $this->db->insert('user_detail', $data);
    }

    function verifyEmail($cond, $registerStatus = 2)
    {
        $data = array(
            'email_verify_status' => 1,
            'email_verify_date' => date("Y-m-d H:i:s"),
            'register_status' => $registerStatus
        );

        $this->db->where($cond);
        return $this->db->update('m_user_register', $data);
    }

    function updateRegister($cond, $data)
    {
        $this->db->where($cond);
        return $this->db->update('m_user_register', $data);
    }
}
