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

	<script type="text/javascript" src="js/binary-tree.js"></script>
	<script type="text/javascript" src="js/sort-table.js"></script>
</head>
<body>
<?php 
	include("nav_bar.php"); 
	generateNavBar("homework_viewer");
?>
<div id="sort-buttons">
	<button id="sortByTitle" onclick="sortBy('title')">Sort By Subject</button>
	<button id="sortByDueDate" onclick="sortBy('date')">Sort By Due Date</button>
</div>
<?php
	include("php/generate_table.php");
?>
</div>
</body>
</html>