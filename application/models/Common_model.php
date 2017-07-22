<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Common_model extends CI_Model {

    public function &__get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    function select_all($tbl) {
        $data = $this->db->get($tbl);
        return $data->result();
    }

    function select_where($table, $id) {
        $qry = $this->db->get_where($table, $id);
        $respond = $qry->result();
        return $respond;
    }

    function select_where_row($table, $id) {
        $qry = $this->db->get_where($table, $id);
        return $qry->row();
    }

    function select_update($table, $data, $id) {
        $query = $this->db->update($table, $data, $id);
        return $query;
    }

    function insert($table, $data) {
        $query = $this->db->insert($table, $data);
        $id = $this->db->insert_id();
        return $id;
    }

    function delete_where($tbl, $where) {
        $query = $this->db->delete($tbl, $where);
        return $query;
    }

    function inserted_id($table, $data) {
        $insert_id = $this->db->insert($table, $data);
        return $this->db->insert_id();
    }

    function get_matrixuser($user_id, $plan_id, $earning_id) {
        $plan_info = $this->select_where_row('matrix_plans', array('id' => $plan_id));
        $get_level = $this->select_where('user_accounts', array('plan' => $plan_id));
        $get_user = '';
        $commission_percentage = '';
        $get_username = '';
        foreach ($get_level as $user) {
            if ($get_user == "") {
                $get_count = $this->select_where('earning_history', array('user_id' => $user->uacc_id));
                if (count($get_count) >= 341 && count($get_count) < 681) {
                    $get_counts = count($get_count) - 340;
                } elseif (count($get_count) >= 681 && count($get_count) < 1021) {
                    $get_counts = count($get_count) - 680;
                } else {
                    $get_counts = count($get_count);
                }
                if ($get_counts < 4) {
                    $commission_percentage = 20;
                } else if ($get_counts < 16) {
                    $commission_percentage = 20;
                } else if ($get_counts < 64) {
                    $commission_percentage = 5;
                } else if ($get_counts < 256) {
                    $commission_percentage = 5;
                }
                if ($get_counts == 340 && $user->level < 3) {
                    $current_level = $this->db->get_where('user_accounts', array('uacc_id' => $user->uacc_id))->row();
                    $this->select_update('user_accounts', array('level' => $current_level->level + 1), array('uacc_id' => $user->uacc_id));
                }
                if ($get_counts < 340) {
                    $get_user = $user->uacc_id;
                    $get_username = $user->uacc_username;
                }
            }
        }
        if ($get_user != "") {
            $commission = ($plan_info->plan_amount * $commission_percentage) / 100;
            $commission_data = array(
                'user_id' => $get_user,
                'for_user_id' => $user_id,
                'commission_amount' => $commission,
                'plan_id' => $plan_id);
            $this->insert('user_commission', $commission_data);
            $earning_data = array(
                'user_id' => $get_user,
                'type' => 'Credit',
                'subject' => 'User Matrix Commission For the User',
                'commission_type' => 'Now No Type Of Commission Is Define',
                'amount' => $commission);
            $this->update_user_earnings($earning_data, $get_user, $commission_data, '+', $earning_id);
        } else {
            echo "All users are full!";
            die();
        }
        return true;
    }
    function update_user_earnings($earnings_data, $user_id, $commission_data, $amount_type, $earning_id) {
        $userinfo = $this->select_where_row('user_accounts', array('uacc_id' => $user_id));
        if ($amount_type == '+') {
            $final_earnings = $userinfo->earnings + $earnings_data['commission_amount'];
        } else if ($amount_type == '-') {
            $final_earnings = $userinfo->earnings - $earnings_data['commission_amount'];
        }
        $this->select_update('user_accounts', array('earnings' => $final_earnings), array('uacc_id' => $user_id));
        $this->select_update('user_accounts', array('reffrence_id' => $user_id), array('uacc_id' => $commission_data['for_user_id']));

        $this->select_update('earning_history', $earnings_data, array('id' => $earning_id));
        return true;
    }

}
