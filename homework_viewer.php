<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Home</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="js/jquery-2.2.1.min.js"></script>
	<script type="text/javascript" src="js/toggle-table-data.js"></script>
	<link rel="stylesheet" type="text/css" href="css/homework-viewer.css">
	<link rel="stylesheet" type="text/css" href="css/nav-bar.css">
</head>
<body>
<?php 
	include("nav_bar.php"); 
	generateNavBar("homework_viewer");
?>
<?php
	include("php/generate_table.php");
?>
</body>
</html>