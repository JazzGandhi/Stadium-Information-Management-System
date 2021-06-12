<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add Schedule</title>
        <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous"> -->
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="stylesheet" href="../css/style.css">
        <link rel="shortcut icon" href="../images/favicon.png" />
        <?php
        function console_log($output, $with_script_tags = true) {
            $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
        ');';
            if ($with_script_tags) {
                $js_code = '<script>' . $js_code . '</script>';
            }
            echo $js_code;
        }
        
        if(isset($_POST['insert'])){
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $s_date=$_POST["s_date"];
                $stime=$_POST["s_time"];
                $etime=$_POST["e_time"];
                if($stime >= $etime){
                    $errMSG="Start Time cannot be after end time";
                }
                else{
                    $stitle=$_POST["s_title"];
                    $sdesc=$_POST["s_description"];
                    $sysID=$_SESSION["systemID"];
                    $sql = "INSERT INTO schedule(s_date,start_time,end_time,title,s_description,systemID) VALUES('$s_date','$stime','$etime','$stitle','$sdesc','$sysID')";
                    $result=$conn->query($sql);
                    if($result){
                        $scMSG="Succesfully added!";
                        header('Location:viewSchedule.php');
                    }
                    else{
                        $errMSG="Couldn't add. Please try again later!";
                        die($conn->error);
                    }
                }
                
                
            }
        }
        if(isset($_POST['cancel'])){
            header('Location:viewSchedule.php');				
        }
        mysqli_close($conn);
        ?>
    </head>

    <body>
        <div class="container-scroller">
            <?php 
            include("nav.php"); 
            ?>
            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="row">
                        <div class="col-md-12 d-flex align-items-stretch grid-margin">
                            <div class="row flex-grow">
                                <div class="col-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <?php
                                            if (isset($errMSG)) {
                                            ?>
                                                    <div class="form-group">
                                                        <div style="text-align:center; font-size: 14px" class="alert alert-danger alert-icon-left alert-arrow-left alert-info mb-2" role="alert">
                                                            <span class="alert-icon"><i class="fas fa-info"></i></span> <?php echo $errMSG; ?>
                                                        </div>
                                                    </div>
                                            <?php
                                                }
                                            ?>
                                            <?php
                                            if (isset($scMSG)) {

                                                ?>
                                                <div class="form-group">
                                                    <div style="text-align:center; font-size: 14px" class="alert alert-success alert-icon-left alert-arrow-left alert-info mb-2" role="alert">
                                                        <span class="alert-icon"><i class="fas fa-check"></i></span> <?php echo $scMSG; ?>
                                                    </div>
                                                </div>
                                                <?php
                                            }
                                            ?>

                                            <div class="page-header clearfix">
                                                <h2 style="float:left">Add Schedule</h2>				
                                            </div>
                                            <form  method="post">
											<div class="form-group">
                                                <div class="form-group">
													<h3>Date</h3>
													<div class="input-group">
														<?php echo '<input type="date" class="form-control" required name="s_date" value="'.date("Y-m-d").'" >'; ?>
													</div>
												</div>

                                                <div class="form-group">
													<h3>Start Time</h3>
													<div class="input-group">
														<?php echo '<input type="time" class="form-control" name="s_time" required>'; ?>
													</div>
												</div>

                                                <div class="form-group">
													<h3>End Time</h3>
													<div class="input-group">
														<?php echo '<input type="time" class="form-control" name="e_time" required>'; ?>
													</div>
												</div>

                                                <div class="form-group">
													<h3>Title</h3>
													<div class="input-group">
														<?php echo '<input type="text" class="form-control" name="s_title" required>'; ?>
													</div>
												</div>

                                                <div class="form-group">
													<h3>Description</h3>
													<div class="input-group">
														<?php echo '<input type="text" class="form-control" name="s_description" >'; ?>
													</div>
												</div>
												
                                                <button type="submit" class="btn btn-dark mr-2" name="insert">Submit</button>
												<input type="button" class="btn btn-light" name="cancel" value="Cancel" onclick="window.location.href='viewSchedule.php'"/>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    <script src="../vendors/js/vendor.bundle.base.js"></script>
    <script src="../vendors/js/vendor.bundle.addons.js"></script>
    <script src="../js/off-canvas.js"></script>
    <script src="../js/misc.js"></script>
    </body>

</html>