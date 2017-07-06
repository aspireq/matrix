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
                            <li><a href="index.html"><i class="fa fa-home" aria-hidden="true"></i> Home</a>
                            </li>
                            <li class="active-bre"><a href="#"> Dashboard</a>
                            </li>
                            <li class="page-back"><a href="index.html"><i class="fa fa-backward" aria-hidden="true"></i> Back</a>
                            </li>
                        </ul>
                    </div>
                    <!--== DASHBOARD INFO ==-->
                    <div class="sb2-2-1">
                        <h2>Admin Dashboard</h2>
                        <p>The .table class adds basic styling (light padding and only horizontal dividers) to a table:</p>
                        <div class="db-2">
                            <ul>
                                <li>
                                    <div class="dash-book dash-b-1">
                                        <h5>Listings</h5>
                                        <h4>948</h4>
                                        <a href="#">View more</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="dash-book dash-b-2">
                                        <h5>Users</h5>
                                        <h4>672</h4>
                                        <a href="#">View more</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="dash-book dash-b-3">
                                        <h5>Enquirys</h5>
                                        <h4>689</h4>
                                        <a href="#">View more</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="dash-book dash-b-4">
                                        <h5>Events</h5>
                                        <h4>24</h4>
                                        <a href="#">View more</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <section>
            <div class="fixed-action-btn vertical">
                <a class="btn-floating btn-large red pulse">
                    <i class="large material-icons">mode_edit</i>
                </a>
                <ul>
                    <li><a class="btn-floating red"><i class="material-icons">insert_chart</i></a>
                    </li>
                    <li><a class="btn-floating yellow darken-1"><i class="material-icons">format_quote</i></a>
                    </li>
                    <li><a class="btn-floating green"><i class="material-icons">publish</i></a>
                    </li>
                    <li><a class="btn-floating blue"><i class="material-icons">attach_file</i></a>
                    </li>
                </ul>
            </div>
        </section>
        <script src="<?php echo base_url(); ?>include_files/js/jquery.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/bootstrap.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/materialize.min.js"></script>
        <script src="<?php echo base_url(); ?>include_files/js/custom.js"></script>
    </body>
</html>