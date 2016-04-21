<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Upload Homework</title>
	<link rel="stylesheet" type="text/css" href="css/nav-bar.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/submit-homework.css">
</head>
<body>
<?php
include("nav_bar.php");
generateNavBar("other");
?>
<form method="post" action="php/upload_homework.php" enctype="multipart/form-data">
	<?php
	//get username from session variable
	$pupilID = $_SESSION['username'];
	//initialise connection to database
	$conn = new mysqli("localhost", "root", "root", "homework_planner");
	//get the current url
	$url = $_SERVER['REQUEST_URI'];
	//split the url by the delimeter "=" and get the second index which will be the homework ID
	$homeworkID = explode("=", $url)[1];
	//get the homework title to display above the form so that the pupil knows what homework he's submitting
	$homework = $conn->query("SELECT * FROM `homework_table` WHERE (`homework_id`) = ('$homeworkID')")->fetch_assoc();
	$homeworkTitle = $homework['title'];
	echo "<h2>$homeworkTitle</h2>"; 
	//output the homework ID and pupil ID has hidden inputs so that when the user submits the form
	//the other PHP script will contain the information it need to add the submission and files to the database
	//as they are hidden the user cannot tamper with them and so they need no validation
	echo "<input type=\"hidden\" value=\"$homeworkID\" name=\"homework_id\">";
	echo "<input type=\"hidden\" value=\"$pupilID\" name=\"pupil_id\">";
	?>
	<input type="file" name="fileToUpload[]" id="file" multiple>
	<input type="submit" name="createHomework" id="submit" value="Submit Homework"></input>
</form>
</body>
</html>