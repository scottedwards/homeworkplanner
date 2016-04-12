<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("print.php");
if ($_POST) {
	$files = $_FILES['fileToUpload'];
	if (count($files['name']) == 1) {
		$homeworkID = $_POST['homework_id'];
		$pupilID = $_POST['pupil_id'];

		include("file_handler.php");
		uploadFiles($files, "submissions", $homeworkID, $pupilID);
		echo "<h2>Homework Submitted!</h2>";
		echo "<a href=\"../homework_viewer.php\">Click here to view other homework</a>";
	} else {
		echo "<h2>You have to upload one file!";
	}
}
?>