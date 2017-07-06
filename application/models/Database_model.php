<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Database_model extends CI_Model {

    public function &__get($key) {
        $CI = & get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);
        return $CI->$key;
    }

    function check_existing_account($email_id) {
        $CI = &get_instance();
        $this->db2 = $CI->load->database('db2', TRUE);
        $qry = $this->db2->query("SELECT * FROM user_accounts where uacc_email = '" . $email_id . "'");
        $data = $qry->row_array();
        $final_data = array();
        $final_data['data'] = $data;
        $result_arr = $this->db2->query('select * from demo_user_profiles where upro_uacc_fk = "' . $data['uacc_id'] . '"')->row();        
        if (!empty($result_arr)) {
            $final_data['data']['upro_first_name'] = $result_arr->upro_first_name;
            $final_data['data']['upro_last_name'] = $result_arr->upro_last_name;
            $final_data['data']['landline_no'] = $result_arr->landline_no;
            $final_data['data']['mobile_no'] = $result_arr->mobile_no;
        }
        return $final_data['data'];
    }

}
