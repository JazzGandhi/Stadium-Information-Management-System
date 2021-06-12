<!DOCTYPE html>
<?php 
	include("header.php");
	require_once '../db_connect.php';
	$userinfo=$_SESSION["change"];
	$fields=array("uname","cuid","salary","urole","mngtype");
	foreach($fields as $field){
		if($userinfo[$field]==NULL)
			$userinfo[$field]="";
	}
	$mngtype=array();
	$sql="SELECT * from management_type";
	$result=$conn->query($sql);
	if($result){
		while($row=$result->fetch_assoc()){
			array_push($mngtype,$row["mngtype"]);
		}
	}

	$sysID=$_SESSION['systemID'];
	$sql="SELECT * from stadinfo where systemID='".$sysID."'";
	$res=$conn->query($sql);
	$row=$res->fetch_assoc();
	$creatorCUID=$row["creatorcuid"];


	function console_log($output, $with_script_tags = true) {
		$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
	');';
		if ($with_script_tags) {
			$js_code = '<script>' . $js_code . '</script>';
		}
		echo $js_code;
	}

	if ($_SERVER['REQUEST_METHOD']=="POST"){
		$info=array();
		$info["uname"]=$userinfo["uname"];
		$info["cuid"]=$userinfo["cuid"];
		$info["salary"]=$_POST["salary"];
		$info["role"]=$_POST["role"];
		if($info["role"]=="Staff")
			$info["mngtype"]=$_POST["mngtype"];
		console_log("Salary:".$_POST["salary"]);
		console_log("Role:".$info["role"]);
		if($info["role"]==NULL || $info["role"]=="" )
			$info["role"]=$userinfo["urole"];
		$sql='UPDATE users SET salary=" '.$info["salary"].' ",urole="'.$info["role"].'" where cuid="'.$info["cuid"].'"';
		if($conn->query($sql)){
			//it was updated..
			//now if the role is staff,update staff_type table
			if($info["role"]="Staff"){
				$sql='UPDATE staff_type SET mngtype="'.$info["mngtype"].'" where staffcuid="'.$info["cuid"].'"';
				if($conn->query($sql)){
					//both updates successfully made
					$scMSG="Update success!!";
					header("refresh:0.3;url=viewSystem.php");
					exit;
				}
			}
			else{
				$scMSG="Update success!!";
				header("refresh:0.3;url=viewSystem.php");
				exit;
			}
			
		}
		else
			$errMSG="Update failure! Please try again later.";

	}



?>
<html lang="en">

	<head>
		<meta charset="utf-8">

		<!-- Latest compiled and m	inified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>User Info</title>
		<link rel="stylesheet" href="../vendors/iconfonts/mdi/css/materialdesignicons.min.css">
		<link rel="stylesheet" href="../vendors/css/vendor.bundle.base.css">
		<link rel="stylesheet" href="../vendors/css/vendor.bundle.addons.css">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
		<link rel="stylesheet" href="../css/style.css">
		<link rel="icon" href="../images/favicon.png" />
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
											<div class="page-header clearfix">
												<h2 style="float:left">User Info Update</h2>				
											</div>
											</br>
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
											<form class="forms-sample" method="post">
											<div class="form-group">
												<div class="panel panel-info" style="display:inline-block;border:none;">
													<?php echo '<div class="panel-heading" style="max-width:max-content;">Username:  '.$userinfo["uname"].'</div>' ?>
												</div>
												<br/>
												<div class="panel panel-info" style="display:inline-block;border:none;">
													<?php echo '<div class="panel-heading" style="max-width:max-content;">User CUID:  '.$userinfo["cuid"].'</div>' ?>
												</div>

												<div class="form-group">
													<h3>Salary</h3>
													<div class="input-group">
														<?php echo '<input type="text" autofocus class="form-control" value="'.$userinfo["salary"].'" name="salary" required>'; ?>
													</div>
												</div>

												<?php
													if($userinfo["urole"]=="Staff"){
															echo '
															<label class="radio-inline"><input type="radio" name="role" value="Staff" checked>Staff</label>
															<label class="radio-inline"><input type="radio" name="role" value="Supervisor" >Supervisor</label>
															';
													}
													else if($userinfo["cuid"]==$creatorCUID){
														echo '
														<label class="radio-inline"><input type="radio" name="role" value="Staff" disabled>Staff</label>
														<label class="radio-inline"><input type="radio" name="role" value="Supervisor" checked >Supervisor</label>
														';
													}
													else{
														echo '
														<label class="radio-inline"><input type="radio" name="role" value="Staff" >Staff</label>
														<label class="radio-inline"><input type="radio" name="role" value="Supervisor" checked >Supervisor</label>
														';
													}
												?>

												<div class="maybehide">
													<div class="panel-heading" style="max-width:max-content;">Management Type</div>
													<div class="dropdown">
														<!-- <button class="btn btn-default dropdown-toggle" type="button" id="menu1" data-toggle="dropdown" name="type" value="Type">Type</button> -->
														<select id="menulisted" name="mngtype">
														<?php
															echo '<option role="menuitem" value="" selected disabled hidden>Select</option>';
															foreach($mngtype as $mng){
																if($userinfo["mngtype"]==$mng)
																	echo '<option role="menuitem"  style="color:green;" value="'.$mng.'">'.$mng.'</option>';
																else
																	echo '<option role="menuitem" value="'.$mng.'">'.$mng.'</option>';
															}
														?>
														</select>
													</div>
												</div>
												<script>
													var ele = document.getElementsByName('role');
													if(ele[1].checked){
														document.getElementsByClassName("maybehide")[0].style.display = "none";
													}
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
												</script>

											</div>
												<button type="submit" class="btn btn-dark mr-2" name="insert">Submit</button>
												<input type="button" class="btn btn-light" name="cancel" value="Cancel" onclick="window.location.href='viewSystem.php'"/>
											</form>									
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