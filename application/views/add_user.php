<!DOCTYPE html>
<html lang="en">
    <?php echo $common; ?>
    <body>
        <?php echo $header; ?>
        <div class="container-fluid sb2">
            <div class="row">
                <?php echo $sidebar; ?>
                <div class="sb2-2">
                    <div class="sb2-2-2">
                        <ul>
                            <li><a href="<?php echo base_url(); ?>user"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                            </li>
                            <li class="active-bre"><a href="<?php echo base_url(); ?>user/add_user"> Add New User</a>
                            </li>
                            <li class="page-back"><a href="index.html"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                            </li>
                        </ul>
                    </div>
                    <div class="sb2-2-add-blog sb2-2-1">
                        <div class="box-inn-sp">
                            <div class="inn-title">
                                <h4>Add User</h4>                                
                            </div>
                            <div class="bor">
                                <form method="post" accept-charset="">
                                    <?php if ($message != "") { ?>
                                        <div class="alert <?php echo $error_class; ?> fade in">
                                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>                                            
                                            <?php echo $message; ?>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="uacc_username" name="uacc_username" type="text" class="validate" value="<?php echo (!empty($user_info)) ? $user_info['uacc_username'] : ''; ?>" <?php echo (!empty($user_info) && $this->uri->segment(3) != "") ? 'readonly=""' : ''; ?>>
                                            <label for="uacc_username">Username</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="uacc_email" name="uacc_email" type="email" class="validate" value="<?php echo (!empty($user_info)) ? $user_info['uacc_email'] : ''; ?>" <?php echo (!empty($user_info) && $this->uri->segment(3) != "") ? 'readonly=""' : ''; ?>>
                                            <label for="uacc_email">Email</label>
                                        </div>
                                    </div>
                                    <?php if (empty($user_info)) { ?>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="passwordmain" name="passwordmain" type="password" class="validate">
                                                <label for="passwordmain">Password</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="inputPasswordConfirm" name="inputPasswordConfirm" type="password" class="validate">
                                                <label for="inputPasswordConfirm">Confirm Password</label>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="mobile_no" name="mobile_no" type="text" class="validate" value="<?php echo (!empty($user_info) && $user_info['mobile_no'] != "") ? $user_info['mobile_no'] : ''; ?>">
                                            <label for="mobile_no">Mobile</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="landline_no" name="landline_no" type="text" class="validate" value="<?php echo (!empty($user_info) && $user_info['landline_no'] != "") ? $user_info['landline_no'] : ''; ?>">
                                            <label for="landline_no">Landline No.</label></div>
                                    </div> 
                                    <label for="">User Type</label>
                                    <div class="row input-field col s12">
                                        <input name="user_type" type="radio" id="sub_admin" value="2" <?php echo (!empty($user_info) && $user_info['uacc_group_fk'] == 2) ? 'checked' : ''; ?> />
                                        <label for="sub_admin">Sub Admin</label>
                                        <input name="user_type" type="radio" id="ad_client" value="3" <?php echo (!empty($user_info) && $user_info['uacc_group_fk'] == 3) ? 'checked' : ''; ?> />
                                        <label for="ad_client">Ad Client</label>
                                        <input name="user_type" type="radio" id="data_entry" value="4" <?php echo (!empty($user_info) && $user_info['uacc_group_fk'] == 4) ? 'checked' : ''; ?> />
                                        <label for="data_entry">Data Entry</label>
                                    </div>
                                    <input type="hidden" name="edit_id" name="edit_id" value="<?php echo (!empty($user_info) && $user_info['uacc_id'] != "") ? $user_info['uacc_id'] : ''; ?>">
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input type="submit" class="waves-effect waves-light btn-large" value="Submit" name="add_new_bank" id="add_new_bank">
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap.min.js"></script>        
        <script src="<?php echo base_url(); ?>include_files/js/materialize.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/custom.js"></script>
    </body>
</html>