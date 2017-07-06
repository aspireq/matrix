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
                            <li class="active-bre"><a href="<?php echo base_url(); ?>user/add_bank"> Add New Bank</a>
                            </li>
                            <li class="page-back"><a href="index.html"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                            </li>
                        </ul>
                    </div>
                    <div class="sb2-2-add-blog sb2-2-1">
                        <div class="box-inn-sp">
                            <div class="inn-title">
                                <h4>Add Bank</h4>                                
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
                                            <input id="bank_name" name="bank_name" type="text" class="validate" value="<?php echo (!empty($bankinfo) && $bankinfo['bank_name'] != "") ? $bankinfo['bank_name'] : ''; ?>">
                                            <label for="bank_name">Bank Name</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="branch_name" name="branch_name" type="text" class="validate" value="<?php echo (!empty($bankinfo) && $bankinfo['branch_name'] != "") ? $bankinfo['branch_name'] : ''; ?>">
                                            <label for="branch_name">Branch Name</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="account_number" name="account_number" type="text" class="validate" value="<?php echo (!empty($bankinfo) && $bankinfo['account_number'] != "") ? $bankinfo['account_number'] : ''; ?>">
                                            <label for="account_number">Account Number</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="ifc_code" name="ifc_code" type="text" class="validate" value="<?php echo (!empty($bankinfo) && $bankinfo['ifc_code'] != "") ? $bankinfo['ifc_code'] : ''; ?>">
                                            <label for="ifc_code">IFSC Code</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="pancard_no" name="pancard_no" type="text" class="validate" value="<?php echo (!empty($bankinfo) && $bankinfo['pancard_no'] != "") ? $bankinfo['pancard_no'] : ''; ?>">
                                            <label for="pancard_no">Pan Card No.</label>
                                        </div>
                                    </div>
                                    <label for="">Account Type</label>
                                    <div class="row input-field col s12">
                                        <input name="account_type" type="radio" id="current" value="Current Account" <?php echo (!empty($bankinfo) && $bankinfo['account_type'] == "Current Account") ? 'checked' : ''; ?> />
                                        <label for="current">Current Account</label>
                                        <input name="account_type" type="radio" id="savings" value="Savings Account" <?php echo (!empty($bankinfo) && $bankinfo['account_type'] == "Savings Account") ? 'checked' : ''; ?> />
                                        <label for="savings">Savings Account</label>
                                    </div>
                                    <input type="hidden" name="edit_id" name="edit_id" value="<?php echo (!empty($bankinfo) && $bankinfo['id'] != "") ? $bankinfo['id'] : ''; ?>">
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