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
                            <li class="active-bre"><a href="<?php echo base_url(); ?>user/leads"> Leads</a>
                            </li>
                        </ul>
                    </div>
                    <!--                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#verification_modal">Open Modal</button>-->
                    <div class="sb2-2-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-inn-sp">
                                    <div class="inn-title">
                                        <?php if ($message != "") { ?>
                                            <div class="alert <?php echo $error_class; ?> fade in">
                                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>                                            
                                                <?php echo $message; ?>
                                            </div>
                                        <?php } ?>
                                        <h4>All Leads</h4>
                                        <a class="dropdown-button drop-down-meta" href="#" data-activates="dr-users"><i class="material-icons">more_vert</i></a>
                                        <ul id="dr-users" class="dropdown-content">
                                            <li><a href="<?php echo base_url(); ?>user/add_leads">Add New Lead</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-inn">
                                        <div class="table-responsive table-desi">
                                            <table class="table table-hover" id="lead_list">
                                                <thead>
                                                    <tr>
                                                        <th>User Name</th>                                                       
                                                        <th>Email</th>
                                                        <th>Mobile</th>
<!--                                                        <th>address</th>                                                     -->
<!--                                                        <th>description</th>-->
                                                        <th>Date</th>
                                                        <th>Subject</th>
                                                        <th>Stage</th>
                                                        <th>Created date</th>
                                                        <th>Action</th>
<!--                                                        <th>Status</th>-->
                                                    </tr>
                                                </thead>                                                
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php echo $footer; ?>
        <div class="modal fade" id="verification_modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Modal Header</h4>
                    </div>
                    <div class="modal-body">
                        <p>Some text in the modal.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap.min.js"></script>        
        <script src="<?php echo base_url(); ?>include_files/js/materialize.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/jQuery.dataTables.reloadAjax.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/jQuery_dataTables_ColumnFilter.js"></script>
        <script>
            $(document).ready(function () {

            });
            var lead_list;
            $(function () {
                lead_list = $('#lead_list').DataTable({
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url(); ?>user/get_leads",
                    "sServerMethod": "POST",
                    "info": false,
                    "fnServerParams":
                            function (aoData) {
                            },
                    "aaSorting": [[2, 'desc'], [1, 'desc']],
                    "iDisplayLength": 10,
                    "bStateSave": true,
                    "fnCreatedRow": function (nRow, aData, iDataIndex)
                    {
                        $(nRow).attr("id", aData.id);
                    },
                    aoColumnDefs: [
                        {
                            mData: 'contact_person_name',
                            aTargets: [0]
                        },
                        {
                            mData: 'email',
                            aTargets: [1]
                        },
                        {
                            mData: 'mobile',
                            aTargets: [2]

                        },
                        {
                            mData: 'date',
                            aTargets: [3]
                        },
                        {
                            mData: 'subject',
                            aTargets: [4]
                        },
                        {
                            mData: 'stage',
                            aTargets: [5]
//                            mRender: function (data, type, full)
//                            {
//                                var html = '<a onclick=user_verification("' + full['uacc_id'] + '","email_verification");><i class="fa fa-lock" aria-hidden="true"></i></a>';
//                                return html;
//                            }
                        },
                        {
                            mData: 'created_date',
                            aTargets: [6]
                        },
                        {
                            mData: '',
                            aTargets: [7],
                            mRender: function (data, type, full)
                            {
                                if (1 == 1) {
                                    var html = '<a href="<?php echo base_url(); ?>user/add_leads/' + full['id'] + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>            ';
                                    html += '<a href="<?php echo base_url(); ?>user/delete_leads/' + full['id'] + '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                                    return html;
                                } else {
                                    var html = '<a href=""><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>            ';
                                    html += '<a href=""><i class="fa fa-trash" aria-hidden="true"></i></a>';
                                    return html;
                                }
                            }
                        },
//                        {
//                            mData: 'status',
//                            aTargets: [8]
//                            mRender: function (data, type, full)
//                            {
//                                if (full['uacc_suspend'] == 0) {
//                                    var html = '<span style="cursor:pointer;" class="label label-primary" onclick=user_verification("' + full['uacc_id'] + '","suspend_user")>Suspend</span>';
//                                    return html;
//                                } else {
//                                    var html = '<span style="cursor:pointer;" class="label label-primary" onclick=user_verification("' + full['uacc_id'] + '","suspend_user")>Suspended</span>';
//                                    return html;
//                                }
//                            }
//                        }
                    ]
                }
                );
            });
            function user_verification(user_id, verification_type) {
                var x;
                if (verification_type == "email_verification") {
                    var user_message = "Are you sure you want to verify this email address";
                } else if (verification_type == "suspend_user") {
                    var user_message = "Are you sure you want to update suspend status for this user";
                } else if (verification_type == "mobile_verification") {
                    var user_message = "Are you sure you want to verify this mobile no for this user";
                }
                if (confirm(user_message) == true) {
                    x = "ok";
                } else {
                    x = "cancel";
                }
                if (x == "ok") {
                    $.ajax({
                        url: "<?php echo base_url(); ?>auth/user_verification/",
                        type: "POST",
                        data: {user_id: user_id, verification_type: verification_type},
                        dataType: "JSON",
                        success: function (data)
                        {
                            reload_table();
                        }
                    });
                }
            }
            function reload_table() {
                userslist.ajax.reload(null, false);
            }
        </script>
    </body>
</html>