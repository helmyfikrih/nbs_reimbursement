<?php

class Login_model extends CI_model
{

    function login($username, $password)
    {

        $this->db->select('user_id, user_username, user_password, role_id, school_id');
        $this->db->from('kms_user');
        //$this -> db -> where('username', $username);
        //$this -> db -> where('password', MD5($password));

        $this->db->where("(user_username = '$username' AND user_password = '" . md5($password) . "') OR 
        (user_email = '$username' AND user_password = '".md5($password)."')", null, false);
        $this->db->limit(1);
        $query = $this->db->get();

        if ($query->num_rows() == 1) {
            return $query->result();
        } else {
            return false;
        }

    }

    function update_login($username){

        $this->load->library('user_agent');
        if ($this->agent->is_browser()) {
            $agent = $this->agent->browser() . ' ' . $this->agent->version();
        } elseif ($this->agent->is_robot()) {
            $agent = $this->agent->robot();
        } elseif ($this->agent->is_mobile()) {
            $agent = $this->agent->mobile();
        } else {
            $agent = 'Unidentified User Agent';
        }

        $data = array(
            'user_ip' =>$this->input->ip_address(),
            'user_browser'=> $agent,
            'user_last_update' => date('Y-m-d H:i:s')
        );
        $this->db->where('user_username', $username);
        $this->db->update('kms_user', $data);
        
    }

    function getUserPassword(){
        $userId = $this->session->userdata('logged_in')['user_id'];
        $query  = "SELECT user_password FROM kms_user WHERE user_id=$userId";
        return $this->db->query($query)->result_array();
    }

    function changePassword($data){
        $this->db->where('user_id',$this->session->userdata('logged_in')['user_id']);
        return $this->db->update('kms_user',$data);
    }

    function isExistUser($cond){
        $this->db->from('kms_user ku');
        $this->db->where($cond);
        return $this->db->get()->result_array();
    }

    function insertRequest($data){
        return $this->db->insert('kms_user_forgot_password',$data);
    }

    function getDataForgotPassword($cond){
        $this->db->where($cond);
        return $this->db->get('kms_user_forgot_password')->result_array();
    }

    function updateForgotPassword($cond,$data){
        $this->db->where($cond);
        return $this->db->update('kms_user_forgot_password',$data);
    }

    function updateUser($cond,$data){
        $this->db->where($cond);
        return $this->db->update('kms_user', $data);
    }

    function getUserIdbyEmail($email){
        $this->db->select('user_id');
        $this->db->where('user_email',$email);
        return $this->db->get('kms_user')->result_array();
    }
}
