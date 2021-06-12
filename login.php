<!DOCTYPE html>
<?php session_start(); ?>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>StadInfo Login</title>
		<link rel="stylesheet" href="vendors/iconfonts/mdi/css/materialdesignicons.min.css">
		<link rel="stylesheet" href="vendors/css/vendor.bundle.base.css">
		<link rel="stylesheet" href="vendors/css/vendor.bundle.addons.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="shortcut icon" href="images/favicon.jpg" />
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.4.1/css/all.css" integrity="sha384-5sAR7xN1Nv6T6+dT2mhtzEpVJvfS3NScPQTrOxhwjIuvcA67KV2R5Jz6kr4abQsz" crossorigin="anonymous">
	</head>

<body>
		<div class="container-scroller">
			<div class="container-fluid page-body-wrapper full-page-wrapper auth-page">
				<div class="content-wrapper d-flex align-items-center auth theme-one" style="background-color: #424964; background-image: url('https://www.transparenttextures.com/patterns/diagmonds.png');">
					<div class="row w-100">
						<div class="col-lg-4 mx-auto">
							<h3 style="display: block; margin-left: auto; margin-right: auto; margin-bottom: 20px;color:white" width="300">Welcome to StadInfo</h3>
							<div class="auto-form-wrapper">
								<?php 

									function console_log($output, $with_script_tags = true) {
										$js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
									');';
										if ($with_script_tags) {
											$js_code = '<script>' . $js_code . '</script>';
										}
										echo $js_code;
									}
									require_once 'db_connect.php';
									if ($_SERVER['REQUEST_METHOD']=="POST") 
									{ 
										$cuid = $_POST['cuid']; 
										$password = $_POST['upassword']; 
										
										$sql = "SELECT * FROM users WHERE cuid='$cuid';";
										$result = $conn->query($sql);
										
										if ($result) 
										{ 	
											$count = $result->num_rows;
											if(!($count==0) ) //if username exists
											{
												while ($row = $result->fetch_assoc()) 
												{ 		
													if (password_verify($password, $row['upassword'])) //if password is correct
													{	
														$_SESSION["cuid"] = $cuid; 
														$_SESSION["role"] = $row['urole'];
														$_SESSION["systemID"]=$row["systemID"]; 
														$_SESSION["username"] = $row["uname"];
														}
														if($row['urole'] == 'Supervisor')
														{
															header("refresh:0.5;url=pages_supervisor/index.php");
														}
														else if($row['urole'] == 'Staff')
														{
															header("refresh:0.5;url=pages_staff/index.php");
														}
														else{
															//supervisor ka aayega ab
														}
														$scMSG = "Logged in successfully!";
													}
													else 
														$errMSG = "Password is incorrect!";		
												}
											}
											else
											{
												$errMSG = "cuid does not exist!";	
											}
										} 
										else 
										{ 
											$errMSG = "Error: " . $sql . "<br>" . $conn->error; 
										}
									}
									?>

								<form method="post" action="#">
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
									<div class="form-group">
										<label class="label">Enter your unique CUID</label>
										<div class="input-group">
											<input type="text" class="form-control" placeholder="Username" name="cuid" required>
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="mdi mdi-account"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<label class="label">Password</label>
										<div class="input-group">
											<input type="password" class="form-control" placeholder="*********" name="upassword" required>
											<div class="input-group-append">
												<span class="input-group-text">
													<i class="mdi mdi-lock"></i>
												</span>
											</div>
										</div>
									</div>
									<div class="form-group">
										<button type="submit" class="btn btn-dark submit-btn btn-block">Login</button>
									</div>
									<div class="text-block text-center my-3">
										<span class="text-small font-weight-semibold">Don't have an account ?</span>
										<a href="register.php" class="text-black text-small">Register</a>
									</div>
								</form>
							</div>
							<br/>
						</div>
					</div>
				</div>
			</div>
		</div>
		<script src="vendors/js/vendor.bundle.base.js"></script>
		<script src="vendors/js/vendor.bundle.addons.js"></script>
		<script src="js/off-canvas.js"></script>
		<script src="js/misc.js"></script>
	</body>

</html>