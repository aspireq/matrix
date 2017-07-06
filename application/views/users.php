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
                            <li><a href="#"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                            </li>
                            <li class="active-bre"><a href="<?php echo base_url(); ?>user/users"> Users</a>
                            </li>
                        </ul>
                    </div>
<!--                    <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#verification_modal">Open Modal</button>-->
                    <div class="sb2-2-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-inn-sp">
                                    <div class="inn-title">
                                        <h4>All Users</h4>
                                        <a class="dropdown-button drop-down-meta" href="#" data-activates="dr-users"><i class="material-icons">more_vert</i></a>
                                        <ul id="dr-users" class="dropdown-content">
                                            <li><a href="<?php echo base_url(); ?>user/add_user">Add New User</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-inn">
                                        <div class="table-responsive table-desi">
                                            <table class="table table-hover" id="userslist">
                                                <thead>
                                                    <tr>
                                                        <th>User Name</th>                                                       
                                                        <th>Email</th>
                                                        <th>Account Type</th>
                                                        <th>IP Address</th>                                                     
                                                        <th>Action</th>
                                                        <th>Reset Password</th>
                                                        <th>Email Verification</th>
                                                        <th>Mobile Verification</th>
                                                        <th>Suspend</th>
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
            var userslist;
            $(function () {
                userslist = $('#userslist').DataTable({
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url(); ?>user/get_users",
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
                            mData: 'uacc_username',
                            aTargets: [0]
                        },
                        {
                            mData: 'uacc_email',
                            aTargets: [1]
                        },
                        {
                            mData: 'uacc_email',
                            aTargets: [2],
                            mRender: function (data, type, full)
                            {
                                if (full['uacc_group_fk'] == 2) {
                                    var html = 'Sub Admin';
                                } else if (full['uacc_group_fk'] == 3) {
                                    var html = 'Ad Client';
                                } else if (full['uacc_group_fk'] == 4) {
                                    var html = 'Data Entry';
                                }
                                return html;
                            }

                        },
                        {
                            mData: 'uacc_ip_address',
                            aTargets: [3]
                        },
                        {
                            mData: '',
                            aTargets: [4],
                            mRender: function (data, type, full)
                            {
                                var html = '<a href="<?php echo base_url(); ?>user/add_user/' + full['uacc_id'] + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>            ';
                                html += '<a href="<?php echo base_url(); ?>user/add_user/' + full['uacc_id'] + '"><i class="fa fa-trash" aria-hidden="true"></i></a>';
                                return html;
                            }
                        },
                        {
                            mData: '',
                            aTargets: [5],
                            mRender: function (data, type, full)
                            {
                                var html = '<a onclick=user_verification("' + full['uacc_id'] + '","email_verification");><i class="fa fa-lock" aria-hidden="true"></i></a>';
                                return html;
                            }
                        },
                        {
                            mData: '',
                            aTargets: [6],
                            mRender: function (data, type, full)
                            {
                                if (full['uacc_active'] == 0) {
                                    var html = '<span style="cursor:pointer;" class="label label-primary" onclick=user_verification("' + full['uacc_id'] + '","email_verification")>Verify</span>';
                                    return html;
                                } else {
                                    var html = '<span class="label label-primary">Verified</span>';
                                    return html;
                                }
                            }
                        },
                        {
                            mData: '',
                            aTargets: [7],
                            mRender: function (data, type, full)
                            {
                                if (full['ucc_mobile_verified'] == 0) {
                                    var html = '<span style="cursor:pointer;" class="label label-primary" onclick=user_verification("' + full['uacc_id'] + '","mobile_verification")>Verify</span>';
                                    return html;
                                } else {
                                    var html = '<span class="label label-primary">Verified</span>';
                                    return html;
                                }
                            }
                        },
                        {
                            mData: '',
                            aTargets: [8],
                            mRender: function (data, type, full)
                            {
                                if (full['uacc_suspend'] == 0) {
                                    var html = '<span style="cursor:pointer;" class="label label-primary" onclick=user_verification("' + full['uacc_id'] + '","suspend_user")>Suspend</span>';
                                    return html;
                                } else {
                                    var html = '<span style="cursor:pointer;" class="label label-primary" onclick=user_verification("' + full['uacc_id'] + '","suspend_user")>Suspended</span>';
                                    return html;
                                }
                            }
                        }
                    ]
                }
                );
            });
            function user_verification(user_id, verification_type) {
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
            function reload_table() {
                userslist.ajax.reload(null, false);
            }
        </script>
    </body>
</html>