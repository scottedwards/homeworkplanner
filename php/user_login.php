<?php
//if some data has been posted
if ($_POST) {
	//set vaiables from the data supplied in POST
	$username = $_POST['username'];
	$password = $_POST['password'];
	//check whether they want to log in as a teacher or pupil
	if (isset($_POST['pupilSubmit'])) {
		//set follwing variables accordingly
		$table = "pupil_table";
		$type = "pupil";
	} elseif (isset($_POST['teacherSubmit'])) {
		//same for these ones
		$table = "teacher_table";
		$type = "teacher";
	} 


	//initilaise a new connection to the database
	$conn = new mysqli("localhost", "root", "root", "homework_planner");
	//this query selects the password from the table specified above where the field 
	//"username" equals the inputted username from the user
	$loginSql = "SELECT `password` FROM `$table` WHERE (`username`) = ('$username')";
	$result = $conn->query($loginSql);
	//get the results only row (It can only be one row as the username is a primary key)
	//and get the password field from it
	$hashedPassword = ($result->fetch_assoc())['password'];
	//password_verify is a PHP function that checks to see if a hashed password is equal to
	//another hashed password. It returns true if it does. I can't test it by a conventioinal
	//equals sign as the hashed version of a password is diffferent every time you hash it
	if (password_verify($password, $hashedPassword)) {
		//if the passwords do check out then redirect the user to the main page and save their
		//data in session variables so we can access them on other pages
		header("Location: ../homework_viewer.php");
		session_start();
		$_SESSION['username'] = $username;
		$_SESSION['type'] = $type;
	} else {
		//else redirect them back to the log in page
		header("Location: ../log_in.php");
	}
}
?>