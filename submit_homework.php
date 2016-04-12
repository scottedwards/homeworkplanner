<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Upload Homework</title>
	<link rel="stylesheet" type="text/css" href="css/nav-bar.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
</head>
<body>
<?php
include("nav_bar.php");
generateNavBar("other");
?>
<form method="post" action="php/upload_homework.php" enctype="multipart/form-data">
	<?php
	$pupilID = $_SESSION['username'];
	$conn = new mysqli("localhost", "root", "root", "homework_planner");
	$url = $_SERVER['REQUEST_URI'];
	$homeworkID = explode("=", $url)[1];
	$homework = $conn->query("SELECT * FROM `homework_table` WHERE (`homework_id`) = ('$homeworkID')")->fetch_assoc();
	$homeworkTitle = $homework['title'];
	echo "<h4>$homeworkTitle</h4>"; 
	echo "<input type=\"hidden\" value=\"$homeworkID\" name=\"homework_id\">";
	echo "<input type=\"hidden\" value=\"$pupilID\" name=\"pupil_id\">";
	?>
	<input type="file" name="fileToUpload[]" multiple>
	<input type="submit" name="createHomework" id="submit" value="Submit Homework"></input>
</form>
</body>
</html>