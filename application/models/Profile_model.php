<?php

class Profile_model extends CI_model
{

    function isExistUserDetail()
    {
        $userId = $this->session->userdata('logged_in')['user_id'];
        $query = "SELECT 1 FROM user_detail WHERE user_id='$userId'";
        if ($this->db->query($query)->result()) {
            return true;
        } else {
            return false;
        }
    }

    function changeAvatar($userId, $params)
    {
        if ($this->isExistUserDetail()) {
            $data = array(
                'ud_img_name' => $params['file_name'],
                'ud_img_dir' => base_url('assets/images/avatars/') . $params['file_name'],
                'ud_last_update' => date('Y-m-d H:i:s')
            );

            $this->db->where('user_id', $userId);
            return $this->db->update('user_detail', $data);
        } else {
            $data = array(
                'user_id' => $userId,
                'ud_img_name' => $params['file_name'],
                'ud_img_dir' => base_url('assets/images/avatars/') . $params['file_name'],
                'ud_last_update' => date('Y-m-d H:i:s')
            );

            return $this->db->insert('user_detail', $data);
        }
    }

    function updateProfile($params)
    {
        $userId = $this->session->userdata('logged_in')['user_id'];
        if ($this->isExistUserDetail()) {
            $data = array(
                'subject_id' => $params['subject'] ? $params['subject'] : null,
                'user_f_name' => $params['fullName'],
                'ud_gender' => $params['sex'],
                'ud_nik' => $params['nik'],
                'ud_address' => $params['address'],
                'ud_birth_place' => $params['birthPlace'],
                'ud_birth_date' => date("Y-m_d", strtotime($params['birthDate'])),
                'ud_phone' => preg_replace("/[^0-9]/", "", $params['phone']),
                'ud_last_update' => date('Y-m-d H:i:s')
            );
            $this->db->where('user_id', $userId);
            $this->db->update('user_detail', $data);
        } else {
            $data = array(
                'user_id' => $userId,
                'subject_id' => $params['subject'] ? $params['subject'] : null,
                'user_f_name' => $params['fullName'],
                'ud_gender' => $params['sex'],
                'ud_nik' => $params['nik'],
                'ud_address' => $params['address'],
                'ud_birth_place' => $params['birthPlace'],
                'ud_birth_date' => date("Y-m_d", strtotime($params['birthDate'])),
                'ud_phone' => preg_replace("/[^0-9]/", "", $params['phone']),
                'ud_last_update' => date('Y-m-d H:i:s')
            );
            $this->db->insert('user_detail', $data);
        }
        if ($this->db->affected_rows() >= 1) {
            return true;
        } else {
            return false;
        }
    }

    function changeUsername($params)
    {
        $userId = $this->session->userdata('logged_in')['user_id'];
        $data = array(
            'user_username' => $params['username'],
            'user_last_update' => date("Y-m-d H:i:s"),
            'user_last_update_by' => $userId
        );
        $this->db->where('user_id', $userId);
        return $this->db->update('m_user', $data);
    }

    function changeEmail($params)
    {
        $userId = $this->session->userdata('logged_in')['user_id'];
        $data = array(
            'user_email' => $params['email'],
            'user_last_update' => date("Y-m-d H:i:s"),
            'user_last_update_by' => $userId
        );
        $this->db->where('user_id', $userId);
        return $this->db->update('m_user', $data);
    }

    function removeAvatar()
    {
        $userId = $this->session->userdata("logged_in")['user_id'];
        $data = array(
            'ud_img_name' => null,
            'ud_img_dir' => null,
        );
        $this->db->where('user_id', $userId);
        return $this->db->update('user_detail', $data);
    }


    function isExistusername($username)
    {

        $this->db->select('user_username');
        $this->db->from('m_user');
        //$this -> db -> where('username', $username);
        //$this -> db -> where('password', MD5($password));

        $this->db->where("user_username = '$username'", null, false);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }

    function isExistEmail($email)
    {

        $this->db->select('user_username');
        $this->db->from('m_user');
        //$this -> db -> where('username', $username);
        //$this -> db -> where('password', MD5($password));

        $this->db->where("user_email = '$email'", null, false);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return true;
        } else {
            return false;
        }
    }
}
