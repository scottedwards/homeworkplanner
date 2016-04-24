<?php 
if ($_POST) {
	//get the files that the user wants to upload
	$files = $_FILES['fileToUpload'];
	//make sure the number of files is equal to 1 as you can only have one submission per homework per pupil
	if (count($files['name']) == 1) {
		//get the homeworkID and pupilID from the POSTed variables
		$homeworkID = $_POST['homework_id'];
		$pupilID = $_POST['pupil_id'];

		include("file_handler.php");
		//upload the files!
		uploadFiles($files, "submissions", $homeworkID, $pupilID);
		echo "<h2>Homework Submitted!</h2>";
		echo "<a href=\"../homework_viewer.php\">Click here to view other homework</a>";
	} else {
		echo "<style> body { text-align: center; padding: 100px;} </style>";
		echo "<style> a {background-color: orange; color: white; border-radius: 5px; border: none; padding: 10px;} </style>";
		echo "<h2>You have selected to many files, please just upload one next time!</h2>";
		echo "<a href=\"../homework_viewer.php\">Click here to view other homework</a>";
	}
}
?>