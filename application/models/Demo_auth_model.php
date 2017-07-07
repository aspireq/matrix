<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Demo_auth_model extends CI_Model {

    // The following method prevents an error occurring when $this->data is modified.
    // Error Message: 'Indirect modification of overloaded property Demo_cart_admin_model::$data has no effect'.
    public function &__get($key) {
        $CI = & get_instance();
        return $CI->$key;
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // Login
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * login
     * Validate the submitted login details and attempt to log the user into their account.
     */
    function login() {
        $this->load->library('form_validation');

        // Set validation rules.
        $this->form_validation->set_rules('login_identity', 'Identity (Email / Login)', 'required');
        $this->form_validation->set_rules('login_password', 'Password', 'required');

        // If failed login attempts from users IP exceeds limit defined by config file, validate captcha.
        //if ($this->flexi_auth->ip_login_attempts_exceeded()) {
        /**
         * To activate reCAPTCHA, ensure the 'recaptcha_response_field' validation below is uncommented and then comment out the 'login_captcha' validation further below.
         *
         * The custom validation rule 'validate_recaptcha' can be found in '../libaries/MY_Form_validation.php'.
         * The form field name used by 'reCAPTCHA' is 'recaptcha_response_field', this field name IS NOT editable.
         * 
         * Note: To use this example, you will also need to enable the recaptcha examples in 'controllers/auth.php', and 'views/demo/login_view.php'.
         */
        //       $this->form_validation->set_rules('recaptcha_response_field', 'Captcha Answer', 'required|validate_recaptcha');

        /**
         * flexi auths math CAPTCHA
         * Math CAPTCHA is a basic CAPTCHA style feature that asks users a basic maths based question to validate they are indeed not a bot.
         * To activate Math CAPTCHA, ensure the 'login_captcha' validation below is uncommented and then comment out the 'recaptcha_response_field' validation above.
         * 
         * The field value submitted as the answer to the math captcha must be submitted to the 'validate_math_captcha' validation function.
         * The custom validation rule 'validate_math_captcha' can be found in '../libaries/MY_Form_validation.php'.
         * 
         * Note: To use this example, you will also need to enable the math_captcha examples in 'controllers/auth.php', and 'views/demo/login_view.php'.
         */
        # $this->form_validation->set_rules('login_captcha', 'Captcha Answer', 'required|validate_math_captcha['.$this->input->post('login_captcha').']');				
        //  }
        // Run the validation.
        if ($this->form_validation->run()) {
            // Check if user wants the 'Remember me' feature enabled.
            $remember_user = ($this->input->post('remember_me') == 1);

            // Verify login data.
            $result = $this->flexi_auth->login($this->input->post('login_identity'), $this->input->post('login_password'), $remember_user);

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            // Reload page, if login was successful, sessions will have been created that will then further redirect verified users.            
            if ($result) {
                redirect('auth_public');
            } else {
                return FALSE;
            }
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');

            return FALSE;
        }
    }

    function login_via_ajax() {
        $remember_user = ($this->input->post('remember_me') == 1);

        return $this->flexi_auth->login($this->input->post('login_identity'), $this->input->post('login_password'), $remember_user);
    }

    function register_account() {
        $this->load->library('form_validation');

        $validation_rules = array(
            array('field' => 'uacc_email', 'label' => 'Email Address', 'rules' => 'required|valid_email'),
            array('field' => 'uacc_username', 'label' => 'Username', 'rules' => 'required|min_length[4]|identity_available'),
            array('field' => 'passwordmain', 'label' => 'Password', 'rules' => 'required|validate_password'),
            array('field' => 'inputPasswordConfirm', 'label' => 'Confirm Password', 'rules' => 'required|matches[passwordmain]')
        );

        $this->form_validation->set_rules($validation_rules);

        if ($this->form_validation->run()) {
            $email = $this->input->post('uacc_email');
            $username = $this->input->post('uacc_username');
            $password = $this->input->post('passwordmain');

            $user_type = $this->input->post('user_type');
            $reffrence_link = base_url() . 'register?ref=' . strtolower($username);
            if ($this->input->post('reffrence_link')) {
                $reffered_by_link = $this->input->post('reffrence_link');
                $reffered_by = $this->db->query("select uacc_id from user_accounts where reffrence_link = '$reffered_by_link'");
            }

            $profile_data = array(
                'upro_first_name' => $this->input->post('upro_first_name'),
                'upro_last_name' => $this->input->post('upro_last_name'),
                'landline_no' => $this->input->post('landline_no'),
                'mobile_no' => $this->input->post('mobile_no'),
                'reffrence_link' => $reffrence_link
            );

            if ($this->input->post('reffrence_link')) {
                $profile_data['reffered_by'] = $reffered_by->row()->uacc_id;
            }
            // Set whether to instantly activate account.
            // This var will be used twice, once for registration, then to check if to log the user in after registration.
            $instant_activate = FALSE;
            // The last 2 variables on the register function are optional, these variables allow you to:
            // #1. Specify the group ID for the user to be added to (i.e. 'Moderator' / 'Public'), the default is set via the config file.
            // #2. Set whether to automatically activate the account upon registration, default is FALSE. 
            // Note: An account activation email will be automatically sent if auto activate is FALSE, or if an activation time limit is set by the config file.
            $response = $this->flexi_auth->insert_user($email, $username, $password, $profile_data, $user_type, $instant_activate);
            if ($response) {
                if ($reffrence_link != "") {
                    $check_reffrels = $this->select_where_row('user_accounts', array('reffrence_link' => $this->input->post('reffrence_link')));
                    if (!empty($check_reffrels)) {
                        $this->db->update('user_accounts', array('reffrence_registration' => $check_reffrels->reffrence_registration + 1), array('uacc_id' => $check_reffrels->uacc_id, 'reffrence_link' => $this->input->post('reffrence_link')));
                    }
                }
                $email_data = array('identity' => $email, 'username' => $username);
                $this->flexi_auth->send_email($email, 'Welcome', 'registration_welcome.tpl.php', $email_data);
                $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
                $this->session->set_flashdata('inserted_user_id', true);
                return true;
            }
            $this->data['user_info'] = $this->input->post();
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());
            $this->session->set_flashdata('inserted_user_id', false);
            return false;
        }
        $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
        $this->data['user_info'] = $this->input->post();
        $this->session->set_flashdata('inserted_user_id', false);
        return FALSE;
    }

    function select_where_row($table, $id) {
        $qry = $this->db->get_where($table, $id);
        return $qry->row();
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // Account Activation
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * resend_activation_token
     * Resends a new account activation token to a users email address.
     */
    function resend_activation_token() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('activation_token_identity', 'Identity (Email / Login)', 'required');

        if ($this->form_validation->run()) {
            $response = $this->flexi_auth->resend_activation_token($this->input->post('activation_token_identity'));

            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            ($response) ? redirect('auth') : redirect('auth/resend_activation_token');
        } else {
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');
            return FALSE;
        }
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // Reseting Passwords
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * forgotten_password
     * Sends a 'Forgotten Password' email to a users email address. 
     * The email will contain a link that redirects the user to the site, a token within the link is verified, and the user can then manually reset their password.
     */
    function forgotten_password() {
        $this->load->library('form_validation');

        $this->form_validation->set_rules('forgot_password_identity', 'Identity (Email / Login)', 'required');

        // Run the validation.
        if ($this->form_validation->run()) {
            // The 'forgotten_password()' function will verify the users identity exists and automatically send a 'Forgotten Password' email.
            $response = $this->flexi_auth->forgotten_password($this->input->post('forgot_password_identity'));

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            $mystring = $this->flexi_auth->get_messages();
            $findme = 'has been sent to reset';
            $pos = strpos($mystring, $findme);
            if ($pos === false) {
                
            } else {
                $this->session->set_flashdata('mail_sent', 1);
            }
            return true;
           // redirect('auth/forgot_password');
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');

            return FALSE;
        }
    }

    /**
     * manual_reset_forgotten_password
     * This example lets the user manually reset their password rather than automatically sending them a new random password via email.
     * The function validates the user via a token within the url of the current site page, then validates their current and newly submitted passwords are valid.
     */
    function manual_reset_forgotten_password($user_id, $token) {
        $this->load->library('form_validation');

        // Set validation rules
        // The custom rule 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
        $validation_rules = array(
            array('field' => 'new_password', 'label' => 'New Password', 'rules' => 'required|validate_password|matches[confirm_new_password]'),
            array('field' => 'confirm_new_password', 'label' => 'Confirm Password', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);

        // Run the validation.
        if ($this->form_validation->run()) {
            // Get password data from input.
            $new_password = $this->input->post('new_password');

            // The 'forgotten_password_complete()' function is used to either manually set a new password, or to auto generate a new password.
            // For this example, we want to manually set a new password, so ensure the 3rd argument includes the $new_password var, or else a  new password.
            // The function will then validate the token exists and set the new password.
            $this->flexi_auth->forgotten_password_complete($user_id, $token, $new_password);

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            redirect('auth/manual_reset_forgotten_password');
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');

            return FALSE;
        }
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // Manage User Account
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * update_account
     * Updates a users account and profile data.
     */

    /**
     * change_password
     * Updates a users password.
     */
    function change_password() {
        $this->load->library('form_validation');

        // Set validation rules.
        // The custom rule 'validate_password' can be found in '../libaries/MY_Form_validation.php'.
        $validation_rules = array(
            array('field' => 'current_password', 'label' => 'Current Password', 'rules' => 'required'),
            array('field' => 'new_password', 'label' => 'New Password', 'rules' => 'required|validate_password|matches[confirm_new_password]'),
            array('field' => 'confirm_new_password', 'label' => 'Confirm Password', 'rules' => 'required')
        );

        $this->form_validation->set_rules($validation_rules);

        // Run the validation.
        if ($this->form_validation->run()) {
            // Get password data from input.
            $identity = $this->flexi_auth->get_user_identity();
            $current_password = $this->input->post('current_password');
            $new_password = $this->input->post('new_password');

            // Note: Changing a password will delete all 'Remember me' database sessions for the user, except their current session.
            $response = $this->flexi_auth->change_password($identity, $current_password, $new_password);

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message1', $this->flexi_auth->get_messages());

            // Redirect user.
            // Note: As an added layer of security, you may wish to email the user that their password has been updated.
            ($response) ? redirect('auth_public/dashboard') : redirect('auth_public/change_password');
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');

            return FALSE;
        }
    }

    /**
     * send_new_email_activation
     * This demo has 2 methods of updating a logged in users email address.
     * The first option simply allows the users to change their email address along with the rest of their account data via entering it into a form fields.
     * The second option requires users to verify their email address via clicking a link that is sent to that same email address.
     * The purpose of the second option is to prevent users entering a mispelt email address, which would then prevent the user from logging back in.
     */
    function send_new_email_activation() {
        $this->load->library('form_validation');

        // Set validation rules.
        // The custom rule 'identity_available' can be found in '../libaries/MY_Form_validation.php'.
        $validation_rules = array(
            array('field' => 'email_address', 'label' => 'Email', 'rules' => 'required|valid_email|identity_available'),
        );

        $this->form_validation->set_rules($validation_rules);

        // Run the validation.
        if ($this->form_validation->run()) {
            $user_id = $this->flexi_auth->get_user_id();

            // The 'update_email_via_verification()' function generates a verification token that is then emailed to the user.
            $this->flexi_auth->update_email_via_verification($user_id, $this->input->post('email_address'));

            // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
            $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

            redirect('auth_public/dashboard');
        } else {
            // Set validation errors.
            $this->data['message'] = validation_errors('<p class="error_msg">', '</p>');

            return FALSE;
        }
    }

    /**
     * verify_updated_email
     * Verifies a token within the current url and updates a users email address. 
     */
    function verify_updated_email($user_id, $token) {
        // Verify the update email token and if valid, update their email address.
        $this->flexi_auth->verify_updated_email($user_id, $token);

        // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        // Redirect user.
        // Logged in users are redirected to the restricted public user dashboard, otherwise the user is redirected to the login page.
        if ($this->flexi_auth->is_logged_in()) {
            redirect('auth_public/dashboard');
        } else {
            redirect('auth/login');
        }
    }

    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	
    // Manage User Address Book
    ###++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++###	

    /**
     * manage_address_book
     * Loops through a POST array of all address IDs that where checked, and then proceeds to delete the addresses from the users address book.
     * Note: The address book table ('demo_user_address') is used in this demo as an example of relating additional user data to the auth libraries account tables. 
     */
    function manage_address_book() {
        // Delete addresses.
        if ($delete_addresses = $this->input->post('delete_address')) {
            foreach ($delete_addresses as $address_id => $delete) {
                // Note: As the 'delete_address' input is a checkbox, it will only be present in the $_POST data if it has been checked,
                // therefore we don't need to check the submitted value.
                $this->flexi_auth->delete_custom_user_data('demo_user_address', $address_id);
            }
        }

        // Save any public status or error messages (Whilst suppressing any admin messages) to CI's flash session data.
        $this->session->set_flashdata('message', $this->flexi_auth->get_messages());

        // Redirect user.
        redirect('auth_public/manage_address_book');
    }

}
