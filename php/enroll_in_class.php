<?php 
header("Location: ../homework_viewer.php");
session_start();
$pupilID = $_SESSION['username'];
$conn = new mysqli("localhost", "root", "root", "homework_planner");
	if ($_POST) {
		$classID = $_POST['classID'];
		$enrollInClassSql = "INSERT INTO `register` (`pupil_id`, `class_id`) VALUES ('$pupilID', '$classID')";
		$conn->query($enrollInClassSql);
	}
?>