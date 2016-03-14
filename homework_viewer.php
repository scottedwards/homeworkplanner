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
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<?php 
		$_SESSION['username'] = "scottedwards";
		$_SESSION['type'] = "pupil";
	?>
</head>
<body>
<?php 
	include("nav_bar.php"); 
	generateNavBar("homework_viewer");
?>
<h1>Homework Viewer</h1>
</body>
</html>