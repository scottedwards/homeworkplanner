<?php 
if ($_POST) {
	$homeworkID = $_POST['homework_id'];
	$pupilID = $_POST['pupil_id'];
	$mark = $_POST['mark'];
	$conn = new mysqli("localhost", "root", "root", "homework_planner");

	if (ctype_digit($mark)) {
		$updateMarkSql = "UPDATE `homework_submissions` SET `mark` = ('$mark') WHERE (`homework_id`, `pupil_id`) = ('$homeworkID', '$pupilID')";
		$conn->query($updateMarkSql);
	} else {
		echo "<h3>You can only put numbers in as a mark!</h3>";
	}

}
?>