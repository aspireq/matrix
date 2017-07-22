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
                            <li class="active-bre"><a href="<?php echo base_url(); ?>user/add_lead"> Add New Lead</a>
                            </li>
                            <li class="page-back"><a href="index.html"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                            </li>
                        </ul>
                    </div>
                    <div class="sb2-2-add-blog sb2-2-1">
                        <div class="box-inn-sp">
                            <div class="inn-title">
                                <h3>device id:<span id="deviceid"></span></h3>
                                <h4 id="up">Add Lead Info</h4>                                
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
                                            <input id="name" name="contact_person_name" type="text" class="validate" value="<?php echo (!empty($lead_info)) ? $lead_info['contact_person_name'] : ''; ?>" <?php echo (!empty($lead_info) && $this->uri->segment(3) != "") ? 'readonly=""' : ''; ?>>
                                            <label class="active" for="name">Contact Person Name</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="email" name="email" type="email" class="validate" value="<?php echo (!empty($lead_info)) ? $lead_info['email'] : ''; ?>" <?php echo (!empty($lead_info) && $this->uri->segment(3) != "") ? 'readonly=""' : ''; ?>>
                                            <label class="active" for="email">Email</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="mobile" name="mobile" type="text" class="validate" value="<?php echo (!empty($lead_info)) ? $lead_info['mobile'] : ''; ?>" <?php echo (!empty($lead_info) && $this->uri->segment(3) != "") ? 'readonly=""' : ''; ?>>
                                            <label for="mobile">Mobile</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="address" name="address" class="validate"><?php echo (!empty($lead_info) && $lead_info['address'] != "") ? $lead_info['address'] : ''; ?></textarea>
                                            <label for="address">Address</label>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <textarea id="description" name="description" class="validate"><?php echo (!empty($lead_info) && $lead_info['description'] != "") ? $lead_info['description'] : ''; ?></textarea> 
                                            <label for="description">Description</label></div>
                                    </div> 
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <input id="date" name="date" type="text" class="validate" value="<?php echo (!empty($lead_info) && $lead_info['date'] != "") ? $lead_info['date'] : ''; ?>">
                                            <label for="date">Date</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select id="source" name="source" type="text" class="validate">
                                                <option value="--">Select One</option>
                                                <option <?php
                                                if ($lead_info['source'] == "Advertiesment") {
                                                    echo 'selected = "selected"';
                                                }
                                                ?>>Advertiesment</option>
                                                <option <?php
                                                if ($lead_info['source'] == "Website") {
                                                    echo 'selected = "selected"';
                                                }
                                                ?>>Website</option>
                                                <option <?php
                                                if ($lead_info['source'] == "Justdial") {
                                                    echo 'selected = "selected"';
                                                }
                                                ?>>Justdial</option>
                                                <option <?php
                                                if ($lead_info['source'] == "Sulekha") {
                                                    echo 'selected = "selected"';
                                                }
                                                ?>>Sulekha</option>
                                                <option <?php
                                                if ($lead_info['source'] == "Others") {
                                                    echo 'selected = "selected"';
                                                }
                                                ?>>Others</option>
                                            </select>
                                            <label for="source">Source</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select name="stage" id="stage" class="validate">
                                                <option value="">Select Stage</option>
                                                <option id="new" <?php
                                                if ($lead_info['stage'] == 'New') {
                                                    echo 'selected = "selected"';
                                                }
                                                ?>> New</option>
                                                <option id="converted" <?php
                                                if ($lead_info['stage'] == 'Converted') {
                                                    echo 'selected = "selected"';
                                                }
                                                ?>> Converted</option>
                                                <option id="lost" <?php
                                                if ($lead_info['stage'] == 'Lost') {
                                                    echo 'selected = "selected"';
                                                }
                                                ?>> Lost</option>
                                            </select>
                                            <label for="stage">Stage</label></div>
                                    </div>
                                    <div class="row">
                                        <div class="input-field col s12">
                                            <select id="subject" name="subject" type="text" class="validate">
                                                <option value="">Select Subject</option>
                                                <option <?php
                                                if ($lead_info['subject'] == 'Website') {
                                                    echo 'selected = "selected"';
                                                }
                                                ?>>Website</option>
                                                <option <?php
                                                if ($lead_info['subject'] == 'Apps') {
                                                    echo 'selected = "selected"';
                                                }
                                                ?>>Apps</option>
                                            </select>
                                            <label for="subject">Subject</label></div>
                                    </div>
                                    <?php if ($lead_info['email']) { ?>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="submit" class="waves-effect waves-light btn-large" value="Update" name="edit" id="add">
                                            </div>
                                        </div>
                                    <?php } else { ?>
                                        <div class="row">
                                            <div class="input-field col s12">
                                                <input type="submit" class="waves-effect waves-light btn-large" value="Submit" name="add" id="add">
                                            </div>
                                        </div>
                                    <?php } ?>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap-datepicker.js"></script> 
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap.min.js"></script>        
        <script src="<?php echo base_url(); ?>include_files/js/materialize.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/custom.js"></script>
        <script>

            $(document).ready(function () {
                var yes = <?php echo json_encode($lead_info['email']); ?>;
                if (yes) {
                    $('#up').html('Update Lead Info');
                }
            });
            $(function () {
                $("#date").datepicker(
                        {
                            format: "yyyy-mm-dd",
                            startDate: new Date(),
                            autoclose: true,
                        });
            });



            uuid = function () {
                var u = 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g,
                        function (c) {
                            var r = Math.random() * 16 | 0,
                                    v = c == 'x' ? r : (r & 0x3 | 0x8);
                            return v.toString(16);
                        });
                return u;
            }


            getDeviceId = function () {
                var current = window.localStorage.getItem("_DEVICEID_")
                if (current)
                    return current;
                var id = uuid();
                window.localStorage.setItem("_DEVICEID_", id);
                return id;
            }

            document.getElementById("deviceid").innerHTML = getDeviceId();

        </script>

    </body>
</html>