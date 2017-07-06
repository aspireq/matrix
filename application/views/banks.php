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
                            <li class="active-bre"><a href="<?php echo base_url(); ?>user/banks"> Bank Accounts</a>
                            </li>
                        </ul>
                    </div>
                    <div class="sb2-2-3">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="box-inn-sp">
                                    <div class="inn-title">
                                        <h4>All Banks</h4>                                        
                                        <a class="dropdown-button drop-down-meta" href="#" data-activates="dr-users"><i class="material-icons">more_vert</i></a>
                                        <ul id="dr-users" class="dropdown-content">
                                            <li><a href="<?php echo base_url(); ?>user/add_bank">Add New Bank</a>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="tab-inn">
                                        <div class="table-responsive table-desi">
                                            <table class="table table-hover" id="bankslist">
                                                <thead>
                                                    <tr>
                                                        <th>Bank Name</th>
                                                        <th>Branch Name</th>
                                                        <th>Account Number</th>
                                                        <th>IFSC Code</th>
                                                        <th>Pan Card No.</th>
                                                        <th>Account Type</th>
                                                        <th>Edit</th>                                                        
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
        <script src="<?php echo base_url(); ?>include_files/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap.min.js"></script>        
        <script src="<?php echo base_url(); ?>include_files/js/materialize.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/custom.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.dataTables.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.dataTables.bootstrap.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/jQuery.dataTables.reloadAjax.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/jQuery_dataTables_ColumnFilter.js"></script>
        <script>
            $(function () {
                var bankslist = $('#bankslist').DataTable({
                    "bServerSide": true,
                    "sAjaxSource": "<?php echo base_url(); ?>user/get_banks",
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
                            mData: 'bank_name',
                            aTargets: [0]
                        },
                        {
                            mData: 'branch_name',
                            aTargets: [1]
                        },
                        {
                            mData: 'account_number',
                            aTargets: [2]
                        },
                        {
                            mData: 'ifc_code',
                            aTargets: [3]
                        },
                        {
                            mData: 'pancard_no',
                            aTargets: [4]
                        },
                        {
                            mData: 'account_type',
                            aTargets: [5]
                        },
                        {
                            mData: '',
                            aTargets: [6],
                            mRender: function (data, type, full)
                            {
                                var html = '<a href="<?php echo base_url(); ?>user/add_bank/' + full['id'] + '"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>';
                                html += "</a>";
                                return html;
                            }
                        }
                    ]
                }
                );
            });
        </script>
    </body>
</html>