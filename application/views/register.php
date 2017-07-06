<?php
if ($_GET['ref'] != "") {
    $reffrence_link = base_url() . 'register?ref=' . $_GET['ref'];
}
?>
<!DOCTYPE html>
<html lang="en">
    <?php echo $common; ?>
    <body>
        <div class="blog-login">
            <div class="blog-login-in">
                <div class="tab-inn">
                    <form method="post">
                        <img src="<?php echo base_url(); ?>include_files/images/logo.png" alt="" />
                        <?php if ($message != "") { ?>                    
                            <div class="alert <?php echo $error_type; ?> alert-dismissable">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <?php echo $message; ?>
                            </div>
                        <?php } ?>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="uacc_email" name="uacc_email" type="email" class="validate" value="<?php echo (!empty($user_info)) ? $user_info['uacc_email'] : ''; ?>">
                                <label for="uacc_email">Email</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="waves-effect waves-light btn-large waves-input-wrapper" style="">
                                    <input class="waves-button-input" value="Check Existing Account" name="check_account" id="check_account" type="submit"></i>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="upro_first_name" name="upro_first_name" type="text" class="validate" value="<?php echo (!empty($user_info) && $user_info['upro_first_name'] != "") ? $user_info['upro_first_name'] : ''; ?>" >
                                <label for="upro_first_name">First Name</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="upro_last_name" name="upro_last_name" type="text" class="validate" value="<?php echo (!empty($user_info) && $user_info['upro_last_name'] != "") ? $user_info['upro_last_name'] : ''; ?>">
                                <label for="upro_last_name">Last Name</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">
                                <input id="uacc_username" name="uacc_username" type="text" class="validate" value="<?php echo (!empty($user_info)) ? $user_info['uacc_username'] : ''; ?>">
                                <label for="uacc_username">Username</label>
                            </div>
                        </div>                        
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="passwordmain" name="passwordmain" type="password" class="validate">
                                <label for="passwordmain">Password</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="inputPasswordConfirm" name="inputPasswordConfirm" type="password" class="validate">
                                <label for="inputPasswordConfirm">Confirm Password</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s6">
                                <input id="landline_no" name="landline_no" type="text" class="validate" value="<?php echo (!empty($user_info) && $user_info['landline_no'] != "") ? $user_info['landline_no'] : ''; ?>">
                                <label for="landline_no">Landline No.</label>
                            </div>
                            <div class="input-field col s6">
                                <input id="mobile_no" name="mobile_no" type="text" class="validate" value="<?php echo (!empty($user_info) && $user_info['mobile_no'] != "") ? $user_info['mobile_no'] : ''; ?>">
                                <label for="mobile_no">Mobile</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="input-field col s12">                           
                                <input type="text" class="validate" name="reffrence_link" id="reffrence_link" value="<?php echo ($reffrence_link != "") ? $reffrence_link : "" ?>" readonly="">
                                <label for="reffrence_link">Reffrence Link</label>
                            </div>
                        </div>
                        <input name="user_type" type="hidden" id="user_type" value="4" />
                        <div class="row">
                            <div class="input-field col s12">
                                <i class="waves-effect waves-light btn-large waves-input-wrapper" style="">
                                    <input class="waves-button-input" name="register_account" id="register_account" value="Create New Account" type="submit"></i>
                            </div>
                        </div>
                        <a href="<?php echo base_url();?>login" class="for-pass">Login</a>
                    </form>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/materialize.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/custom.js"></script>
    </body>
</html>