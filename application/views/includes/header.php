<div class="container-fluid sb1">
            <div class="row">
                <!--== LOGO ==-->
                <div class="col-md-2 col-sm-3 col-xs-6 sb1-1">
                    <a href="#" class="btn-close-menu"><i class="fa fa-times" aria-hidden="true"></i></a>
                    <a href="#" class="atab-menu"><i class="fa fa-bars tab-menu" aria-hidden="true"></i></a>
                    <a href="<?php echo base_url();?>user" class="logo"><img src="<?php echo base_url(); ?>include_files/images/logo1.png" alt="" />
                    </a>
                </div>
                <!--== SEARCH ==-->
<!--                <div class="col-md-6 col-sm-6 mob-hide">
                    <form class="app-search">
                        <input type="text" placeholder="Search..." class="form-control">
                        <a href="#"><i class="fa fa-search"></i></a>
                    </form>
                </div>-->
                <!--== NOTIFICATION ==-->
<!--                <div class="col-md-2 tab-hide">
                    <div class="top-not-cen">
                        <a class='waves-effect btn-noti' href='#'><i class="fa fa-commenting-o" aria-hidden="true"></i><span>5</span></a>
                        <a class='waves-effect btn-noti' href='#'><i class="fa fa-envelope-o" aria-hidden="true"></i><span>5</span></a>
                        <a class='waves-effect btn-noti' href='#'><i class="fa fa-tag" aria-hidden="true"></i><span>5</span></a>
                    </div>
                </div>-->
                <!--== MY ACCCOUNT ==-->
                <div class="col-md-2 col-sm-3 col-xs-6 pull-right">
                    <!-- Dropdown Trigger -->
                    <a class='waves-effect dropdown-button top-user-pro' href='#' data-activates='top-menu'><img src="<?php echo base_url(); ?>include_files/images/user/6.png" alt="" />My Account <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </a>

                    <!-- Dropdown Structure -->
                    <ul id='top-menu' class='dropdown-content top-menu-sty'>                        
                        <li><a href="user-add.html" class="waves-effect"><i class="fa fa-user-plus" aria-hidden="true"></i> Profile</a>
                        </li>
                        <li class="divider"></li>
                        <li><a href="<?php echo base_url();?>auth/logout" class="ho-dr-con-last waves-effect"><i class="fa fa-sign-in" aria-hidden="true"></i> Logout</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>