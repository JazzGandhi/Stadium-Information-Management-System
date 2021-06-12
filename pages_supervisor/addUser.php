<!DOCTYPE html>
<?php 
include("header.php");
require_once '../db_connect.php';

$mngtype=array();
$sql="SELECT * from management_type";
$result=$conn->query($sql);
if($result){
    while($row=$result->fetch_assoc()){
        array_push($mngtype,$row["mngtype"]);
    }
}

?>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>Add User</title>
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

        if(isset($_POST["Check"])){
            $userID=$_POST["userID"];
            console_log("IDHAR PAHUCHA: ".$userID);
            $sql = "SELECT * from users where cuid='$userID' and systemID is NULL";
            $result=$conn->query($sql);
            console_log($result->num_rows);
            if($result && $result->num_rows==1){
                $scMSG="User present! You can add him to the system!";
            }
            else{
                $errMSG="User doesn't exist or already is in another system..";
            }
        }
        if(isset($_POST['insert'])){
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            else{
                $usercuid=$_POST["userID"];
                $urole=$_POST["role"];
                $usalary=$_POST["salary"];
                if($urole=="Staff")
                    $mngtype=$_POST["mngtype"];
                
                $sql = "SELECT * from users where cuid='$usercuid' and systemID is NULL";
                $result=$conn->query($sql);
                
                if($result && $result->num_rows==1){
                    //there exists one user so we can add him to system
                    $sysID=$_SESSION["systemID"];
                    console_log($sysID);
                    console_log($urole);
                    console_log($usalary);
                    console_log($usercuid);
                    $sql="UPDATE users SET systemID='$sysID',urole='$urole',salary='$usalary' where cuid='$usercuid'";
                    if($conn->query($sql)){
                        if($urole="Staff"){
                            $sql="INSERT into staff_type VALUES('$mngtype','$usercuid')";
                            if($conn->query($sql)){
                                header("Location:viewSystem.php");
                                exit;
                            }
                        }
                        else{
                            header("Location:viewSystem.php");
                            exit;
                        }
                    }
                    else{
                        $errMSG="Some error with the server..Please try again later!";
                    }
                    
                }
                else{
                    $errMSG="User CUID doesn't exist..Please recheck!";
                }
            }
        }
        if(isset($_POST['cancel'])){
            header('Location:viewSystem.php');				
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
                                                <h2 style="float:left">Add User</h2>				
                                            </div>
                                            <form  method="post">
											<div class="form-group">
												<div class="panel panel-info" style="display:inline-block;border:none;">
                                                    
                                                    <?php
                                                    if(isset($userID))
                                                        echo '<input type="number" class="form-control" style="width:150px;" name="userID" value="'.$userID.'" >' ;
                                                    else{
                                                        echo '<input type="number" class="form-control" style="width:150px;" name="userID" >'; 
                                                    }
                                                    ?>
                                                    <button type="submit" class="btn btn-primary" name="Check">Check</button>
												</div>
                                                <div class="form-group">
													<h3>Salary</h3>
													<div class="input-group">
														<?php echo '<input type="text" class="form-control" name="salary">'; ?>
													</div>
												</div>

												<?php
                                                    echo '
                                                    <label class="radio-inline"><input type="radio" name="role" value="Staff" checked>Staff</label>
                                                    <label class="radio-inline"><input type="radio" name="role" value="Supervisor" >Supervisor</label>
                                                    ';
												?>

												<div class="maybehide">
													<div class="panel-heading" style="max-width:max-content;">Management Type</div>
													<div class="dropdown">
														<!-- <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" name="type" value="Type">Type</button> -->
														<select id="menulisted" name="mngtype">
														<?php
															echo '<option role="menuitem" value="" selected disabled hidden>Select</option>';
															foreach($mngtype as $mng){
																	echo '<option role="menuitem" value="'.$mng.'">'.$mng.'</option>';
															}
														?>
														</select>
													</div>
												</div>
												<script>
													// var ele = document.getElementsByName('role');
													// if(ele[1].checked){
													// 	document.getElementsByClassName("maybehide")[0].style.display = "none";
													// }
													$('#menulisted option').on('click', function(){
														var selected = $(this).text();
														console.log(selected);
														// document.getElementsByName("type")[0].value=selected;
														$("#menu1").html(selected);
														// document.getElementsByName(document.getElementById('menu1'))[0].value = selected;
													});

													$('input[type=radio]').click(function(e) {//jQuery works on clicking radio box
														var value = $(this).val(); //Get the clicked checkbox value
														console.log("PRINT",value);
														if(value=="Supervisor"){
															console.log("inside");
															document.getElementsByClassName("maybehide")[0].style.display = "none";
														}
														else{
															document.getElementsByClassName("maybehide")[0].style.display = "block";
														}
													});
												</script><br><br>
                                                <button type="submit" class="btn btn-dark mr-2" name="insert">Submit</button>
												<input type="button" class="btn btn-light" name="cancel" value="Cancel" onclick="window.location.href='viewSystem.php'"/>
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