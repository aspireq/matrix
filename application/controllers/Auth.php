<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Auth extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('Database_model');
        $this->load->library('session');
        $this->load->helper('url');
        $this->load->helper('form');
        $this->load->library('bitcoin');
        $this->auth = new stdClass;

        $this->load->library('flexi_auth');
        if ($this->flexi_auth->is_logged_in_via_password() && uri_string() != 'auth/logout') {
            if ($this->session->flashdata('message')) {
                $this->session->keep_flashdata('message');
            }
        }
        $this->data = null;
        if ($this->flexi_auth->is_logged_in()) {
            $this->data['userinfo'] = $this->userinfo = $this->flexi_auth->get_user_by_identity_row_array();
            $this->user_id = $this->data['userinfo']['uacc_id'];
        }
    }

    function index() {
        $this->login();
    }

    function set_earnings() {
        $data = $this->Common_model->select_where('businesses', array('user_id !=' => 2, 'is_approved' => 1, 'earnings <' => 5));
        foreach ($data as $business) {
            $check_history = $this->Common_model->select_where_row('business_earnings', array('business_id' => $business->id));
            if (empty($check_history)) {
                echo "Not Found";
                $business_earnings = array();
                $business_earnings['extra_incentive'] = 1;
                $business_earnings['company_name'] = 1;
                $business_earnings['category_subcategory'] = 1;
                $business_earnings['address'] = 1;
                $business_earnings['landline'] = 1;
                $business_earnings['mobile'] = 1;
                $this->Common_model->select_update('businesses', array('earnings' => 5), array('id' => $business->id));
                $this->Common_model->inserted_id('business_earnings', $business_earnings);
                $total_earnings = 10;
                $getuserbalance = $this->Common_model->select_where_row('user_accounts', array('uacc_id' => $business->user_id));
                $user_earnings = $getuserbalance->earnings + $total_earnings;
                $this->Common_model->select_update('user_accounts', array('earnings' => $user_earnings), array('uacc_id' => $business->user_id));
            } else {
                echo "Check" . $check_history->business_id;
                echo "1111111";
                die();
            }
        }
        die();
    }

    public function include_files() {
        $this->data['header'] = $this->load->view('includes/header', $this->data, TRUE);
        $this->data['common'] = $this->load->view('includes/common', $this->data, TRUE);
        $this->data['sidebar'] = $this->load->view('includes/sidebar', $this->data, TRUE);
        $this->data['footer'] = $this->load->view('includes/footer', $this->data, TRUE);
        return $this->data;
    }

    public function home() {
        $this->data = $this->include_files();
        $this->load->view('home', $this->data);
    }

    function admin() {
        if ($this->input->post()) {
            $this->load->model('demo_auth_model');
            $this->demo_auth_model->login();
        }
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->load->view('admin/login', $this->data);
    }

    function register() {
        if ($this->input->post('check_account') == "Check Existing Account") {
            $email_id = $this->input->post('uacc_email');
            $this->data['user_info'] = $this->Database_model->check_existing_account($email_id);
            if (empty($this->data['user_info'])) {
                $this->data['user_info'] = $this->input->post();
                $this->data['error_type'] = 'alert-info';
                $this->data['message'] = "No Account Associated with this email id";
            } else {
                $this->data['error_type'] = 'alert-info';
                $this->data['message'] = "Account Associated with old database";
            }
        } else if ($this->input->post('register_account') == "Create New Account") {
            $this->load->model('demo_auth_model');
            $result = $this->demo_auth_model->register_account();
            $this->data['error_type'] = ($this->session->flashdata('inserted_user_id') == true) ? 'alert-success' : 'alert-danger';
        }
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('register', $this->data);
    }

    function activate_account($user_id, $token = FALSE) {
        $this->flexi_auth->activate_user($user_id, $token, TRUE);
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
        redirect('auth');
    }

    function login() {
        if ($this->flexi_auth->is_logged_in()) {
            redirect('auth_public');
        }
        if ($this->input->post()) {
            $this->load->model('demo_auth_model');
            $result = $this->demo_auth_model->login();
        }
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('login', $this->data);
    }

    function forgot_password() {
        if ($this->input->post()) {
            $this->load->model('demo_auth_model');
            $this->demo_auth_model->forgotten_password();
        }
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('forgot_password', $this->data);
    }

    function manual_reset_forgotten_password($user_id = FALSE, $token = FALSE) {
        // If the 'Change Forgotten Password' form has been submitted, then update the users password.
        if ($this->input->post()) {
            $this->load->model('demo_auth_model');
            $this->demo_auth_model->manual_reset_forgotten_password($user_id, $token);
        }
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->data = $this->include_files();
        $this->load->view('reset_password', $this->data);
    }

    function resend_activation_token() {
        // If the 'Resend Activation Token' form has been submitted, resend the user an account activation email.
        if ($this->input->post('send_activation_token')) {
            $this->load->model('demo_auth_model');
            $this->demo_auth_model->resend_activation_token();
        }
        // Get any status message that may have been set.
        $this->data['message'] = (!isset($this->data['message'])) ? $this->session->flashdata('message') : $this->data['message'];
        $this->load->view('demo/public_examples/resend_activation_token_view', $this->data);
    }

    function auto_reset_forgotten_password($user_id = FALSE, $token = FALSE) {
        $this->flexi_auth->forgotten_password_complete($user_id, $token, FALSE, TRUE);
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
        redirect('auth');
    }

    function logout() {
        $this->flexi_auth->logout(TRUE);
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
        redirect('login');
    }

    function user_verification() {
        $user_id = $this->input->post('user_id');
        $verification_type = $this->input->post('verification_type');
        $user_data = array();
        if ($verification_type == "email_verification") {
            $user_data['uacc_active'] = 1;
        } else if ($verification_type == "mobile_verification") {
            $user_data['ucc_mobile_verified'] = 1;
        } else if ($verification_type == "suspend_user") {
            $userinfo = $this->Common_model->select_where_row('user_accounts', array('uacc_id' => $user_id));
            if ($userinfo->uacc_suspend == 1) {
                $user_data['uacc_suspend'] = 0;
            } else {
                $user_data['uacc_suspend'] = 1;
            }
        }
        $this->Common_model->select_update('user_accounts', $user_data, array('uacc_id' => $user_id));
        die(json_encode(true));
    }

    function get_record() {
        $table_name = $this->input->post('table_name');
        $id = $this->input->post('id');
        $table_coloum = $this->input->post('table_coloum');
        $data = $this->Common_model->select_where_row($table_name, array($table_coloum => $id));
        die(json_encode($data));
    }

}