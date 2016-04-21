<?php 
if ($_POST) {
	//get all variables POSTed from the pupil's submission form
	$homeworkID = $_POST['homework_id'];
	$pupilID = $_POST['pupil_id'];
	$mark = $_POST['mark'];
	//declare new database connection
	$conn = new mysqli("localhost", "root", "root", "homework_planner");

	//make sure mark is a digit as we want all marks to be of the same data type to sort them
	if (ctype_digit($mark)) {
		$updateMarkSql = "UPDATE `homework_submissions` SET `mark` = ('$mark') WHERE (`homework_id`, `pupil_id`) = ('$homeworkID', '$pupilID')";
		//update marks
		$conn->query($updateMarkSql);
	} else {
		echo "<h3>You can only put numbers in as a mark!</h3>";
	}

}
?>