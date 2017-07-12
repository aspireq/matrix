<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->model('Admin_model');
        $this->load->helper('url');
        $this->load->helper('form');

        $this->auth = new stdClass;
        $this->load->library('flexi_auth');

        if (!$this->flexi_auth->is_logged_in_via_password() || $this->flexi_auth->get_user_group_id() != 4) {
            $this->flexi_auth->set_error_message('You must login to access this area.', TRUE);
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            redirect('auth');
        }
        $this->data = null;
        if ($this->flexi_auth->is_logged_in()) {
            $this->data['userinfo'] = $this->userinfo = $this->flexi_auth->get_user_by_identity_row_array();
            $this->user_id = $this->data['userinfo']['uacc_id'];
        }
    }

    public function include_files() {
        $this->data['header'] = $this->load->view('includes/header', $this->data, TRUE);
        $this->data['common'] = $this->load->view('includes/common', $this->data, TRUE);
        $this->data['sidebar'] = $this->load->view('includes/sidebar', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('includes/footer', $this->data, TRUE);
        return $this->data;
    }

    function index() {
        $this->data = $this->include_files();
        $this->load->view('home', $this->data);
    }

    function banks() {
        $this->data = $this->include_files();
        $this->load->view('banks', $this->data);
    }

    function users() {
        $this->data = $this->include_files();
        $this->load->view('users', $this->data);
    }

    function add_user($user_id = null) {
        if ($this->input->post()) {
            if ($this->input->post('edit_id')) {
                $this->Common_model->select_update('user_accounts', array('uacc_group_fk' => $this->input->post('user_type')), array('uacc_id' => $this->input->post('edit_id')));
                $this->Common_model->select_update('demo_user_profiles', array('landline_no' => $this->input->post('landline_no'), 'mobile_no' => $this->input->post('mobile_no')), array('upro_uacc_fk' => $this->input->post('edit_id')));
                if ($this->input->post('change_password') == 1) {
                    echo "111";
                    die();
                }
                $this->session->set_flashdata('message', "User Information saved successfully");
                $this->data['error_class'] = 'alert-success';
            } else {
                $this->load->model('demo_auth_model');
                $result = $this->demo_auth_model->register_account();
                $this->data['error_class'] = ($this->session->flashdata('inserted_user_id') == true) ? 'alert-success' : 'alert-danger';
            }
        }
        if ($user_id != null) {
            $this->data['user_info'] = (array) $this->Common_model->select_where_row('user_accounts', array('uacc_id' => $user_id));
            $add_userinfo = $this->Common_model->select_where_row('demo_user_profiles', array('upro_uacc_fk' => $user_id));
            $this->data['user_info']['mobile_no'] = $add_userinfo->mobile_no;
            $this->data['user_info']['landline_no'] = $add_userinfo->landline_no;
        }
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('add_user', $this->data);
    }

    function add_bank($bank_id = null) {
        if ($this->input->post()) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
            $this->form_validation->set_rules('branch_name', 'Branch Name', 'required');
            $this->form_validation->set_rules('account_number', 'Account Number', 'required');
            $this->form_validation->set_rules('ifc_code', 'IFSC Code', 'required');

            $bank_data = array(
                'user_id' => $this->user_id,
                'bank_name' => $this->input->post('bank_name'),
                'branch_name' => $this->input->post('branch_name'),
                'account_number' => $this->input->post('account_number'),
                'ifc_code' => $this->input->post('ifc_code'),
                'pancard_no' => $this->input->post('pancard_no'),
                'account_type' => $this->input->post('account_type')
            );
            if ($this->form_validation->run()) {
                if ($this->input->post('edit_id')) {
                    $this->Common_model->select_update('bankinfo', $bank_data, array('id' => $this->input->post('edit_id')));
                    $this->data['message'] = "Bank Information Saved Successfully !";
                    $this->data['error_class'] = 'alert-success';
                } else {
                    $check_bank = $this->Common_model->select_where_row('bankinfo', array('user_id' => $this->user_id));
                    if (empty($check_bank)) {
                        $this->Common_model->insert('bankinfo', $bank_data);
                        $this->data['message'] = "Bank Information Saved Successfully !";
                        $this->data['error_class'] = 'alert-success';
                    } else {
                        $this->data['message'] = "You are not allowed to enter more than one bank !";
                        $this->data['error_class'] = 'alert-danger';
                    }
                }
            } else {
                $this->data['bankinfo'] = $this->input->post();
                $this->data['message'] = validation_errors();
                $this->data['error_class'] = 'alert-danger';
            }
        }
        if ($bank_id != null) {
            $this->data['bankinfo'] = (array) $this->Common_model->select_where_row('bankinfo', array('id' => $bank_id, 'user_id' => $this->user_id));
        }
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('add_bank', $this->data);
    }

    function group() {
        if ($this->userinfo['plan'] == "") {
            $this->data['is_plan_exits'] = false;
            if ($this->input->post()) {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('plan_id', 'Plan', 'required');
                $this->form_validation->set_rules('plan_amount', 'Plan Amount', 'required');
                $this->form_validation->set_rules('amount_to_pay', 'Paying Amount', 'required');
                if ($this->form_validation->run()) {
                    $group_data = array(
                        'plan' => $this->input->post('plan_id'),
                        'amount_paid' => $this->input->post('amount_to_pay')
                    );
                    $this->Common_model->select_update('user_accounts', $group_data, array('uacc_id' => $this->user_id));
                    $this->Common_model->get_matrixuser($this->user_id, $this->input->post('plan_id'));
                    $this->data['message'] = "Plan Information Saved Successfully !";
                    $this->data['error_class'] = 'alert-success';
                } else {
                    $this->data['message'] = validation_errors();
                    $this->data['error_class'] = 'alert-danger';
                }
            }
        } else {
            $this->data['is_plan_exits'] = TRUE;
            $this->data['planinfo'] = $this->Common_model->select_where_row('matrix_plans', array('id' => $this->userinfo['plan']));
        }
        $this->data['plans'] = $this->Common_model->select_where('matrix_plans', array('status' => 1));
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('group', $this->data);
    }

    function delete_bank($bank_id = null) {
        $this->Common_model->delete_where('bankinfo', array('id' => $bank_id, 'user_id' => $this->user_id));
        redirect('user/banks');
    }

    function get_banks() {
        $banks = $this->Admin_model->get_bankinfo($this->user_id);
        die($banks);
    }

    function get_users() {
        $banks = $this->Admin_model->get_usersinfo($this->user_id);
        die($banks);
    }

}
