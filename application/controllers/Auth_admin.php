<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth_admin extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->load->database();
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->model('Admin_model');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->auth = new stdClass;
        $this->load->library('flexi_auth');

        if (!$this->flexi_auth->is_logged_in_via_password() || !$this->flexi_auth->is_admin()) {
            $this->flexi_auth->set_error_message('You must login as an admin to access this area.', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }
        $this->data = null;
        $this->data['admininfo'] = $this->flexi_auth->get_user_by_identity_row_array();
    }

    function index() {
        $this->dashboard();
    }

    function include_files() {
        $this->data['header'] = $this->load->view('admin/header', $this->data, TRUE);
        $this->data['sidebar'] = $this->load->view('admin/sidebar', NULL, TRUE);
        $this->data['common'] = $this->load->view('admin/common', NULL, TRUE);
        $this->data['footer'] = $this->load->view('admin/footer', NULL, TRUE);
        return $this->data;
    }

    function dashboard() {        
        $this->data['message'] = $this->session->flashdata('message');
        $this->data = $this->include_files();
        $this->load->view('admin/dashboard', $this->data);
    }

    function user_account() {
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('admin/user_account', $this->data);
    }

    function logout() {
        $this->flexi_auth->logout(TRUE);
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
        redirect('admin');
    }

    function get_user_account() {
        $data = $this->Admin_model->get_user_account();
        die($data);
    }

    function record_status() {
        $table_name = $this->input->post('table_name');
        $table_coloum_name = $this->input->post('table_coloum');
        $table_id = $this->input->post('id');
        $recordinfo = $this->Common_model->select_where_row($table_name, array($table_coloum_name => $table_id));
        if ($recordinfo->status == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $result = $this->Common_model->select_update($table_name, array('status' => $status), array($table_coloum_name => $table_id));
        echo json_encode($result);
        die();
    }

    function susped_user() {
        $recordinfo = $this->Common_model->select_where_row('user_accounts', array('uacc_id' => $this->input->post('user_id')));
        if ($recordinfo->uacc_suspend == 1) {
            $status = 0;
        } else {
            $status = 1;
        }
        $result = $this->Common_model->select_update('user_accounts', array('uacc_suspend' => $status), array('uacc_id' => $this->input->post('user_id')));
        echo json_encode($result);
        die();
    }

    function get_item_info() {
        $table_name = $this->input->post('table_name');
        $table_coloum_name = $this->input->post('table_coloum');
        $table_id = $this->input->post('id');
        $result = $this->Common_model->select_where_row($table_name, array($table_coloum_name => $table_id));
        echo json_encode($result);
        die();
    }

    function web_settings() {
        if ($this->input->post()) {
            $web_settings = array(
                //'running_days' => $this->input->post('running_days'),
                'total_accounts' => $this->input->post('total_accounts'),
                'total_deposited' => $this->input->post('total_deposited'),
                'total_withdraw' => $this->input->post('total_withdraw'),
            );
            $this->Common_model->select_update('webisite_settings', $web_settings, array('id' => 1));
            $this->session->set_flashdata('message', "Web settings saved successfully");
        }
        $this->data['web_settings'] = $this->Common_model->select_where_row('webisite_settings', array('id' => 1));
        $this->data['message'] = $this->session->flashdata('message');
        $this->data = $this->include_files();
        $this->load->view('admin/web_settings', $this->data);
    }

    function deposits() {
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('admin/deposits', $this->data);
    }

    function get_deposits() {
        $data = $this->Admin_model->get_depositinfo();
        die($data);
    }

    function withdraw_requests() {
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('admin/withdraw_requests', $this->data);
    }

    function get_withdraw_requests() {

        $data = $this->Admin_model->get_withdraw_request();
        die($data);
    }

    function accept_withdrawals() {
        $this->load->library('bitcoin');
        $withdrawal_id = $this->input->post('withdrawal_id');
        $withdrawalinfo = $this->Common_model->select_where_row('withdrawals', array('id' => $withdrawal_id));
        $result = $this->bitcoin->CreateWithdrawal($withdrawalinfo->amount, 'BTC', '3Hy6suVXD1Ajm4eCEsWhdAyV4eXyejTNQv');
        if ($result['error'] == 'ok') {
            $response = $result['result'];
            $withdrawals_data = array(
                'user_id' => $withdrawalinfo->user_id,
                'withdrawal_id' => $response['id'],
                'amount' => $response['amount'],
                'record_status' => 1,
                'withdrawal_status' => $response['status']);
            $added_withdrawal = $this->Common_model->select_update('withdrawals', $withdrawals_data, array('id' => $withdrawal_id));
            $withdrawal_status = $this->bitcoin->get_withdrawal_info($response['id']);
            if ($added_withdrawal && $withdrawal_status['error'] == 'ok') {
                $this->db->query("UPDATE `withdrawals` SET `withdrawal_status` = '" . $withdrawal_status['result']['status'] . "', `withdrawal_status_text` = '" . $withdrawal_status['result']['status_text'] . "' WHERE `withdrawals`.`id` = $added_withdrawal");
                $message = "Withdrawal request submitted successfully.";
            } else {
                $message = $withdrawal_status['error'];
            }
        } else {
            $message = $result['error'];
        }
        die(json_encode($message));
    }

    function add_user() {
        // Change webisite settings randomly
        $total_withdraw = mt_rand(1000000, 88888888);
        $total_deposited = mt_rand(1000000, 88888888);
        $total_accounts = mt_rand(1000, 4444);
        $min = 1;
        $max = 100;
        $running_days = rand($min, $max);
        $web_settings = array(
            'total_withdraw' => $total_withdraw,
            'total_deposited' => $total_deposited,
            'total_accounts' => $total_accounts,
            'running_days' => $running_days
        );
        $this->Common_model->select_update('webisite_settings', $web_settings, array('id' => 1));
        // Ends......
        if ($this->input->post()) {
            $this->load->model('demo_auth_model');
            $this->demo_auth_model->register_account();
        }
        $this->data['users'] = $this->Common_model->select_where('user_accounts', array('uacc_group_fk' => 1));
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('admin/add_user', $this->data);
    }

}

/* End of file auth_admin.php */
/* Location: ./application/controllers/auth_admin.php */
