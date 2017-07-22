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
                            <li class="active-bre"><a href="<?php echo base_url(); ?>user/group"> Select Group</a>
                            </li>
                            <li class="page-back"><a href="<?php echo base_url(); ?>user"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                            </li>
                        </ul>
                    </div>
                    <?php if (isset($is_plan_exits) && $is_plan_exits == true) { ?>
                        <div class="sb2-2-add-blog sb2-2-1">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Group</h4>
                                </div>
                                <div class="bor">
                                    <span>Your Group : <?php echo $planinfo->plan_name; ?></span>                                    
                                </div>
                                <div class="bor">
                                    <span>Amount : <?php echo $userinfo['amount_paid']; ?></span>
                                </div>
                            </div>
                        </div>
                    <?php } else { ?>
                        <div class="sb2-2-add-blog sb2-2-1">
                            <div class="box-inn-sp">
                                <div class="inn-title">
                                    <h4>Add Group</h4>
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
                                                <select name="plan_id" id="plan_id" onchange="plans(this.value);">
                                                    <option value="" disabled selected>Choose Category</option>
                                                    <?php foreach ($plans as $plan) { ?>
                                                        <option value="<?php echo $plan->id; ?>"><?php echo $plan->plan_name; ?></option>
                                                    <?php } ?>
                                                </select>
                                                <label>Select Plan</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="plan_amount" name="plan_amount" type="text" class="validate" readonly="">
                                                <label for="plan_amount">Plan Amount</label>
                                            </div>
                                        </div>
                                        <span>Tax Slab : 18% GST</span>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="amount_to_pay" name="amount_to_pay" type="text" class="validate" readonly="">
                                                <label for="amount_to_pay">Paying Amount</label>
                                            </div>
                                        </div>

                                        <!--                                        // here-->
                                            <!--                                        <span>Payment Date</span>-->
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="date_to_pay" name="date_to_pay" type="text" class="validate" readonly="true">
                                                <label for="date_to_pay">Paying Date</label>
                                            </div>
                                        </div>

        <!--                                        <span id="change">Payment Mode</span>-->
                                        <div class="row">
                                            <div class="input-field col s12">
    <!--                                                <input id="mode_to_pay" name="mode_to_pay" type="text" class="validate" readonly="">-->
                                                <select id="mode_to_pay" name="mode_to_pay" class="validate" readonly="true">
                                                    <option id="select">select mode</option>
                                                    <option id="cheque">Cheque</option>
                                                    <option id="cash">Bank Tranfer</option>
                                                </select>
                                                <label for="mode_to_pay">Paying Mode</label>
                                            </div>
                                        </div>
    <!--                                        <span class="common"></span>-->
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input id="pay_id" name="pay_id" type="text" class="validate">
                                                <label for="pay_id" class="common">Paying Id</label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <textarea name="dscriptions" class="validate"></textarea>
                                                <label for="pay_id" class="">Dscriptions</label>
                                            </div>
                                        </div>
                                        <!--end-->
                                        <!--                                    <input type="hidden" name="edit_id" name="edit_id" value="<?php //echo (!empty($bankinfo) && $bankinfo['id'] != "") ? $bankinfo['id'] : '';                                                                        ?>">-->
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="submit" class="waves-effect waves-light btn-large" value="Pay Now" name="add_new_bank" id="add_new_bank">
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap.min.js"></script>        
        <script src="<?php echo base_url(); ?>include_files/js/materialize.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap-datepicker.js"></script> 

        <script>

                                                    $(document).ready(function () {

                                                    });
                                                    $(function () {
                                                        $("#date_to_pay").datepicker(
                                                                {
                                                                    format: "yyyy-mm-dd",
                                                                    autoclose: true,
                                                                });
                                                    });

                                                    $(function () {
                                                        $("select#mode_to_pay").change(function () {
                                                            var pay_mode = $("#mode_to_pay option:selected").val();
                                                            if (pay_mode == 'Cheque') {
                                                                $('.common').html('Cheque No :-');
                                                            }
                                                            if (pay_mode == 'Bank Tranfer') {
                                                                $('.common').html('Transaction Id :-');
                                                            }
                                                        });
                                                    }
                                                    );
                                                    function plans() {
                                                        var selected_plan = $('#plan_id').val();
                                                        $.ajax({
                                                            url: "<?php echo base_url(); ?>auth/get_record/",
                                                            type: "POST",
                                                            data: {table_name: "matrix_plans", id: selected_plan, table_coloum: "id"},
                                                            dataType: "JSON",
                                                            success: function (data)
                                                            {
                                                                var plan_amount = parseFloat(data.plan_amount).toFixed(2);
                                                                var amount_to_pay = parseFloat(Math.abs(plan_amount) + ((plan_amount * 18) / 100)).toFixed(2);
                                                                $('#plan_amount').val(plan_amount);
                                                                $('#amount_to_pay').val(amount_to_pay);
                                                            }
                                                        });
                                                    }
        </script>
    </body>
</html>