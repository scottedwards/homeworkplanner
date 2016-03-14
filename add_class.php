<!DOCTYPE html>
<html>
<head>
	<title>Add Class</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<?php 
		session_start();
		error_reporting(E_ALL);
		ini_set('display_errors', 1);
	?>
</head>
<body>
<?php 
	include("nav_bar.php");
	generateNavBar("add_class");
?>
</body>
</html>