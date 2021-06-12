<?php
	session_start(); 
	if (!isset($_SESSION["cuid"]) || $_SESSION["role"] != 'Supervisor') {   
		header("Location: ../login.php");
	}
?>