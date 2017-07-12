<div class="sb2-1">
    <!--== USER INFO ==-->
    <div class="sb2-12">
        <ul>
            <li><img src="<?php echo base_url(); ?>include_files/images/placeholder.jpg" alt="">
            </li>
            <li>
                <h5><?php echo ucfirst($userinfo['uacc_username']); ?></h5>
            </li>
            <li></li>
        </ul>
    </div>
    <!--== LEFT MENU ==-->
    <div class="sb2-13">
        <ul class="collapsible" data-collapsible="accordion">
            <li><a href="<?php echo base_url(); ?>user" class="menu-active"><i class="fa fa-bar-chart" aria-hidden="true"></i> Dashboard</a>
            </li>
            <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-list-ul" aria-hidden="true"></i> Bank Accounts</a>
                <div class="collapsible-body left-sub-menu">
                    <ul>
                        <li><a href="<?php echo base_url(); ?>user/banks">All Banks Accounts</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-user" aria-hidden="true"></i> Users</a>
                <div class="collapsible-body left-sub-menu">
                    <ul>
                        <li><a href="<?php echo base_url(); ?>user/users">All Users</a>
                        </li>
                        <li><a href="<?php echo base_url(); ?>user/add_user">Add New user</a>
                        </li>
                    </ul>
                </div>
            </li>
            <li><a href="javascript:void(0)" class="collapsible-header"><i class="fa fa-user" aria-hidden="true"></i> Matrix Group</a>
                <div class="collapsible-body left-sub-menu">
                    <ul>
                        <li><a href="<?php echo base_url(); ?>user/group">Group</a>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</div>