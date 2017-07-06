<!DOCTYPE html>
<html lang="en">
    <?php echo $common; ?>
    <body>
        <div class="blog-login">
            <div class="blog-login-in">
                <form method="post">
                    <img src="<?php echo base_url(); ?>include_files/images/logo.png" alt="" />
                    <?php if ($message != "") { ?>                    
                        <div class="alert alert-danger alert-dismissable">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            <?php echo $message; ?>
                        </div>
                    <?php } ?>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="login_identity" name="login_identity" type="text" class="validate">
                            <label for="first_name1">User Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="login_password" name="login_password" type="password" class="validate">
                            <label for="last_name">Password</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <input type="submit" name="check_login" id="check_login" class="waves-effect waves-light btn-large btn-log-in" value="Login"/>
                        </div>
                    </div>
                    <a href="<?php echo base_url(); ?>forgot_password" class="for-pass">Forgot Password?</a>
                    <a href="<?php echo base_url(); ?>register" class="for-pass">Create New Account?</a>
                </form>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/materialize.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/custom.js"></script>
    </body>
</html>