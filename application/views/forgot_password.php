<!DOCTYPE html>
<html lang="en">
    <?php echo $common; ?>
    <body>
        <div class="blog-login">
            <div class="blog-login-in">
                <form>
                    <img src="<?php echo base_url();?>include_files/images/logo.png" alt="" />
                    <div class="row">
                        <div class="input-field col s12">
                            <input id="first_name1" type="text" class="validate">
                            <label for="first_name1">User Name</label>
                        </div>
                    </div>
                    <div class="row">
                        <div class="input-field col s12">
                            <a class="waves-effect waves-light btn-large btn-log-in" href="#">Login</a>
                        </div>
                    </div>
                    <a href="<?php echo base_url();?>login" class="for-pass">Login</a>
                </form>
            </div>
        </div>
        <!--======== SCRIPT FILES =========-->
        <script src="<?php echo base_url();?>include_files/js/jquery.min.js"></script>
        <script src="<?php echo base_url();?>include_files/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url();?>include_files/js/materialize.min.js"></script>
        <script src="<?php echo base_url();?>include_files/js/custom.js"></script>
    </body>
</html>