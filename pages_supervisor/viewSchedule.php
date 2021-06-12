<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';
$sysID=$_SESSION["systemID"];
$sql="SELECT * from stadinfo where systemID='$sysID'";
$result=$conn->query($sql);
if($result){
    $row=$result->fetch_assoc();
    $sysName=$row["systemName"];
    $creatorCUID=$row["creatorcuid"];
    if(!isset($_SESSION["date"])){
        $_SESSION["date"]=date("Y-m-d");
    }
    $sysDate=$_SESSION["date"];
}
?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Schedule</title>
        <link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
        <link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
        <link rel="stylesheet" href="../css/style.css">
        <link rel="shortcut icon" href="../images/favicon.png" />
        <style>
            .icon{
                color: #e24826;
            }
            .icon:hover{
                color: #d3323a;
            }
        </style>
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
                        <div class="col-lg-12 grid-margin stretch-card" >
                            <div class="card">
                                <div class="card-body">
                                    <div class="page-header clearfix">
                                        <h2 style="float:left"> <?php echo $sysName."<br><br>"; ?></h2> 
                                    </div>


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

                                    <form method="post">
                                        <div style="display:inline-block;" >
                                            <?php echo '<input type="date"  name="dispdate" value="'.$sysDate.'" style="max-width:max-content;">'; ?>
                                            <button type="submit" class="btn btn-outline-info" name="displaydate">Display for this date</button>
                                            <br><br>
                                        </div>
                                    <br>
                                    <div class="table-responsive">
                                        <table id="recent-orders" class="table table-hover table-xl mb-0">
                                            <thead>
                                                <tr>
                                                <th class="border-top-0">Date</th>
                                                    <th class="border-top-0">Start Time</th>
                                                    <th class="border-top-0">End Time</th>
                                                    <th class="border-top-0">Title</th>
                                                    <th class="border-top-0">Description</th>
                                                    <td class="border-top-0">Edit</td>
                                                    <td class="border-top-0">Delete</td>
                                                    <?php
                                                    $tddate=$sysDate;
                                                    $schedulsql = "SELECT * 
                                                                    FROM schedule 
                                                                    WHERE systemID='$sysID' and DATE(s_date)='$tddate';";
                                                    $result = $conn->query($schedulsql);
                                                    $schedule_data=array();
                                                    $count=0;
                                                    while ($row = $result->fetch_assoc()){
                                                        $count=$count+1;
                                                        array_push($schedule_data,$row);
                                                    }
                                                    ?>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php   

                                                    $fields=array("start_time","end_time","title","s_description");
                                                    foreach($schedule_data as $schedule){
                                                        $dtfmt=date("d/m/Y", strtotime($schedule["s_date"]));
                                                        echo '<tr>';
                                                        echo '<td>'.$dtfmt.'</td>';
                                                        foreach($fields as $val){
                                                            if($schedule[$val]==NULL)
                                                                echo '<td>--</td>';
                                                            else
                                                                echo '<td>'.$schedule[$val].'</td>';
                                                        }
                                                        echo "<td><input type='submit' class='btn btn-dark submit-btn btn-block' value='Edit' name='".$schedule['s_id']."'></td>";
                                                        echo "<td><input type='submit' class='btn btn-dark btn-danger btn-block' value='Remove' name='9999".$schedule['s_id']."' ></td>";
                                                        echo '</tr>';
                                                    }
                                                 

                                                    function console_log($output, $with_script_tags = true) {
                                                        $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . ');';
                                                        if ($with_script_tags) {
                                                            $js_code = '<script>' . $js_code . '</script>';
                                                        }
                                                        echo $js_code;
                                                    }
                                                    // console_log("HIII");
                                                    if(isset($_POST["add"])){
                                                        echo "<script> location.href='addSchedule.php'; </script>";
                                                        exit;
                                                    }
                                                    else if(isset($_POST["displaydate"])){
                                                        $_SESSION["date"]=$_POST["dispdate"];
                                                        echo "<script> location.href='viewSchedule.php'; </script>";
                                                    }
                                                    else if(isset($_POST) ){
                                                        foreach($schedule_data as $schedule){

                                                            if(isset($_POST[$schedule["s_id"]])){
                                                                
                                                                console_log($user["cuid"]);
                                                                //changes to be done here
                                                                $_SESSION["change_schedule"]=$schedule;
                                                                echo "<script> location.href='editSchedule.php'; </script>";
                                                            }
                                                            else if(isset($_POST['9999'.$schedule["s_id"]])){
                                                                console_log("IN HEREEEE");
                                                                console_log($schedule["s_id"]);
                                                                $delSQL='DELETE FROM schedule where s_id="'.$schedule["s_id"].'"';
                                                                if($conn->query($delSQL)){
                                                                    // $scMSG="Deleted user succesfully";
                                                                    echo "<script> location.href='viewSchedule.php'; </script>";
                                                                }
                                                                else{
                                                                    $errMSG="Couldn't delete schedule. Please try again later!";
                                                                }
                                                            }
                                                        }
                                                    }
                                                ?>
                                            </tbody>
                                        </table>
                                            
                                    </div>
                                        <br><br><br>
                                        <button type="submit" class="btn btn-primary btn-md active" name="add">Add Schedule</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script>
            $(document).ready(function(){
                $('[data-toggle="tooltip"]').tooltip();   
            });
        </script>
        <script src="../vendors/js/vendor.bundle.base.js"></script>
        <script src="../vendors/js/vendor.bundle.addons.js"></script>
        <script src="../js/off-canvas.js"></script>
        <script src="../js/misc.js"></script>
    </body>
</html>