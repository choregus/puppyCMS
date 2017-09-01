<?php
	session_start();
	unset($_SESSION['puppycms-admin']);
	header("Location: login.php");
	exit;
?>