<?php

	error_reporting(E_ALL);
	ini_set('display_errors', 1);

	if ($_POST) {
		$username = $_POST['username'];
		$password = $_POST['password'];
		if (isset($_POST['pupilSubmit'])) {
			$table = "pupil_table";
			$type = "pupil";
		} elseif (isset($_POST['teacherSubmit'])) {
			$table = "teacher_table";
			$type = "teacher";
		} 

		

		$conn = new mysqli("localhost", "root", "root", "homework_planner");
		$loginSql = "SELECT `password` FROM `$table` WHERE (`username`) = ('$username')";
		$result = $conn->query($loginSql);
		$hashedPassword = ($result->fetch_assoc())['password'];

		if (password_verify($password, $hashedPassword)) {
			header("Location: ../homework_viewer.php");
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['type'] = $type;
		} else {
			header("Location: ../log_in.php");
		}
	}
?>