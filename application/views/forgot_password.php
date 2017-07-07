<!DOCTYPE html>
<html lang="en">
    <?php echo $common; ?>
    <body>
        <div class="blog-login">
            <div class="blog-login-in">
                <form method="post">
                    <img src="<?php echo base_url(); ?>include_files/images/logo.png" alt="" />
                    <?php
                    if (is_numeric($this->session->flashdata('mail_sent'))) {
                        $message_status = 'alert-success';
                    } else {
                        $message_status = 'alert-danger';
                    }
                    if ($message != "") {
                        ?>
                        <div class="alert <?php echo $message_status; ?> alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="forgot_password_identity" name="forgot_password_identity" type="text" class="validate">
                            <label for="forgot_password_identity">User Name / Email Id</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="submit" name="check_account" id="check_login" class="waves-effect waves-light btn-large btn-log-in" value="Submit"/>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>login" class="for-pass">Login</a>
                </form>
            </div>
        </div>
        <!--======== SCRIPT FILES =========-->
        <script src="<?php echo base_url(); ?>include_files/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/materialize.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/custom.js"></script>
    </body>
</html>