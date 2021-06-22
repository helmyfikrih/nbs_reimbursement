<?php

class Settings_model extends CI_model
{


    function getSystemSettings()
    {
        $this->db->where('setting_id',1);
        $result =  $this->db->get('kms_system_settings')->result_array();
        foreach ($result as $system){
            $systemData = $system;
        }
        return $systemData;
    }

    function saveGeneral($data){
        $this->db->where('setting_id', 1);
        return $this->db->update('kms_system_settings', $data);
    }
    
    function updateSetting($data) {
        $this->db->where('setting_id', 1);
        return $this->db->update('kms_system_settings',$data);
    }
}
