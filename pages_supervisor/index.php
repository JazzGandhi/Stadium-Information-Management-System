<!DOCTYPE html>
<?php
include("header.php");
require_once '../db_connect.php';
?>
<html lang="en">

    <head>
        
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>StadInfo</title>
        <!-- plugins:css -->
        <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
        <!-- endinject -->
        <!-- plugin css for this page -->
        <!-- End plugin css for this page -->
        <!-- inject:css -->
        <link rel="stylesheet" href="../css/style.css">
        <!-- endinject -->
        <link rel="shortcut icon" href="../images/favicon.png" />
        <?php

        if($_SESSION["systemID"]==NULL)
            header("refresh:0.5;url=createSystem.php");
            
        $sysID=$_SESSION["systemID"];
        
        $sql="SELECT COUNT(cuid) FROM users where systemID='$sysID' and urole='Supervisor'";
        $result=$conn->query($sql);
        if($result){
            $num_supervisors=$result->fetch_assoc();
            $num_supervisors=$num_supervisors["COUNT(cuid)"];
        }
        else
            $num_supervisors=0;

        $sql="SELECT COUNT(cuid) FROM users where systemID='$sysID' and urole='Staff'";
        if($result=$conn->query($sql)){
            $num_staff=$result->fetch_assoc();
            $num_staff=$num_staff["COUNT(cuid)"];
        }
        else
            $num_staff=0;
        
        // $result = $conn->query('SELECT subjectID FROM subject;'); 
        // $subjectIDarr = array();
        // while($row = $result->fetch_assoc())
        //     array_push($subjectIDarr, $row['subjectID']);
        ?>
    </head>

    <body>
        <div class="container-scroller">
            <?php 
            include("nav.php"); 
            ?>
            <!-- partial -->
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                    <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-account-check icon-lg" style="color:blue;"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Total Supervisors</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo $num_supervisors; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-book text-danger icon-lg"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Total Subjects</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo $num_of_subjects; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-bulletin-board text-warning icon-lg"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Total Classes</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo $num_of_class; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-xl-6 col-lg-6 col-md-6 col-sm-4 grid-margin stretch-card">
                            <div class="card card-statistics">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-left">
                                            <i class="mdi mdi-account-check icon-lg" style="color:blue;"></i>
                                        </div>
                                        <div class="float-right">
                                            <p class="mb-0 text-right">Total Staff</p>
                                            <div class="fluid-container">
                                                <h3 class="font-weight-medium text-right mb-0"><?php echo $num_staff; ?></h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- content-wrapper ends -->
            </div>
            <!-- main-panel ends -->
        </div>
        <!-- page-body-wrapper ends -->
        </div>
    <!-- container-scroller -->

    <!-- plugins:js -->
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script src="../vendors/js/vendor.bundle.addons.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page-->
    <!-- End plugin js for this page-->
    <!-- inject:js -->
    </body>

</html>