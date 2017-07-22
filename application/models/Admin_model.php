<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_model extends CI_Model {

    public function &__get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    function get_usersinfo($user_id) {
        $this->load->library('Datatables');
        $this->datatables->select('user_accounts.uacc_suspend as uacc_suspend,user_accounts.ucc_mobile_verified as ucc_mobile_verified,user_accounts.uacc_active as uacc_active,user_accounts.ucc_mobile_verified as ucc_mobile_verified,user_accounts.uacc_username as uacc_username,user_accounts.uacc_group_fk as uacc_group_fk,user_accounts.uacc_email as uacc_email,user_accounts.uacc_id as uacc_id,user_accounts.uacc_ip_address as uacc_ip_address ,user_accounts.uacc_date_last_login as uacc_date_last_login,user_accounts.uacc_suspend as uacc_suspend');
        $this->datatables->from('user_accounts');
        $this->datatables->where('uacc_group_fk != 1');
        $this->datatables->where('uacc_id !=', $user_id);
        return $this->datatables->generate();
    }

    function get_bankinfo($user_id) {
        $this->load->library('Datatables');
        $this->datatables->select('bankinfo.pancard_no as pancard_no,bankinfo.account_type as account_type,bankinfo.id as id,bankinfo.bank_name as bank_name,bankinfo.branch_name as branch_name,bankinfo.account_number as account_number,bankinfo.ifc_code as ifc_code');
        $this->datatables->from('bankinfo');
        $this->datatables->where('user_id', $user_id);
        $this->datatables->where('status', 1);
        return $this->datatables->generate();
    } 
  function get_leadsinfo() {
        $this->load->library('Datatables');
        $this->datatables->select('leads.id as id,leads.created_date as created_date,leads.contact_person_name as contact_person_name,leads.email as email,leads.mobile as mobile,leads.address as address,leads.description as description,leads.date as date ,leads.source as source,leads.subject as subject ,leads.status as status,leads.stage as stage');
        $this->datatables->from('leads');
//        $this->datatables->where('user_id', $user_id);
//        $this->datatables->where('status', 1);
        return $this->datatables->generate();
    }
}
