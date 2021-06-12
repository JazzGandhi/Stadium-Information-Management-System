<?php
	session_start(); 
	if (!isset($_SESSION["cuid"]) || $_SESSION["role"] != 'Staff') {   
		header("Location: ../login.php");
	}
?>