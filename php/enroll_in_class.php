<?php 
//redirect pupil to the main page before we set any headers
header("Location: ../homework_viewer.php");
//start the session so that we can get session information
session_start();
//get the iusername of the person who's logged in
$pupilID = $_SESSION['username'];
//initialise new connection to database
$conn = new mysqli("localhost", "root", "root", "homework_planner");
//if there has been some data POSTed then...
if ($_POST) {
	//get clasID from posted variables
	$classID = $_POST['classID'];
	//insert new row into register table that has the user's username and the ID of the class they want to join
	$enrollInClassSql = "INSERT INTO `register` (`pupil_id`, `class_id`) VALUES ('$pupilID', '$classID')";
	$conn->query($enrollInClassSql);
}
?>