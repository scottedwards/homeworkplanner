<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
include("php/print.php");

	//get the url of the website. this url contains a parameter of the homework ID of the submissions the teacher wants to see
$url = $_SERVER['REQUEST_URI'];
$homeworkID = explode("=", $url)[1];
	//get all pupils for the class that this homework belongs to
	//firstly get the class ID for the homework
$classID = getRowsFromField($homeworkID, "homework_id", "homework_table")[0];
	//now get the pupils in this class
$register = getRowsFromField($classID['class_id'], "class_id", "register");
$submissions = getRowsFromField($homeworkID, "homework_id", "homework_submissions");

echo "<table>";
	//loop through each pupil
foreach ($register as $row) {
	$pupilID = $row['pupil_id'];
	$pupilName = getRowsFromField($pupilID, "username", "pupil_table")[0]['name'];

		//pre set variables so that if the user has not submitted homework the teacher will know
		//and he can't update marks
	$hasSubmitted = false;
	foreach ($submissions as $submission) {
		if ($submission['pupil_id'] == $pupilID) {
			$file = $submission['path'];
			$expFile = explode("/", $file);
			$fileName = $expFile[count($expFile) - 1];
			$mark = $submission['mark'];
			$hasSubmitted = true;
		}
	}

	$newRow = "<tr><td>";
	$newRow .= "<form method=\"post\">";
	$newRow .= "<h4>$pupilName</h4>";
	$newRow .= "<input type=\"hidden\" name=\"homework_id\" value=\"$homeworkID\">";
	$newRow .= "<input type=\"hidden\" name=\"pupil_id\" value=\"$pupilID\">";
	if ($hasSubmitted) {
		$newRow .= "<p> - <a href=\"$file\" download>$fileName</a></p>";
		$newRow .= "<input type=\"submit\" value=\"Update Mark\" id=\"submit\">";
		$newRow .= "<input type=\"text\" name=\"mark\" value=\"$mark\" id=\"mark\">";	
	} else {
		$newRow .= "<p> - not submitted</p>";
	}
	$newRow .= "</form>";
	$newRow .= "</td></tr>";
	echo "$newRow";
}

echo "</table>";



function getRowsFromField($fieldValue, $fieldName, $table) {
	$tempArray = [];
	$conn = new mysqli("localhost", "root", "root", "homework_planner");
	$getRowSql = "SELECT * FROM `$table` WHERE (`$fieldName`) = ('$fieldValue')";
	$results = $conn->query($getRowSql);
	while ($result = $results->fetch_assoc()) {
		$tempArray[] = $result;
	}
	return $tempArray;
}
?>