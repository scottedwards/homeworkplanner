<?php
include("php/print.php");

//get the url of the website. this url contains a parameter of the homework ID of the submissions the teacher wants to see
$url = $_SERVER['REQUEST_URI'];
$homeworkID = explode("=", $url)[1];
//get all pupils for the class that this homework belongs to
//firstly get the class ID for the homework
$homework = getRowsFromField($homeworkID, "homework_id", "homework_table")[0];
//now get the pupils in this class
$register = getRowsFromField($homework['class_id'], "class_id", "register");
$submissions = getRowsFromField($homeworkID, "homework_id", "homework_submissions");

echo "<table>";
//loop through each pupil
foreach ($register as $row) {
	$pupilID = $row['pupil_id'];
	$pupilName = getRowsFromField($pupilID, "username", "pupil_table")[0]['name'];

	//pre set variables so that if the user has not submitted homework the teacher will know
	//and he can't update marks
	$hasSubmitted = false;
	//loop through each submission and if the pupilID  of the current pupil = the pupilID of the submission then:
	foreach ($submissions as $submission) {
		if ($submission['pupil_id'] == $pupilID) {
			$file = $submission['path'];
			//split the file path (file) by the delimiter "/"
			$expFile = explode("/", $file);
			//select the last index of the split path (the actual file name)
			$fileName = $expFile[count($expFile) - 1];
			//get the submissions mark
			$mark = $submission['mark'];
			$hasSubmitted = true;
		}
	}

	//start building the HTML code for the row
	$newRow = "<tr><td>";
	$newRow .= "<form method=\"post\">";
	//output a heading with the pupil's name
	$newRow .= "<h3 id=\"$pupilID\">$pupilName</h3>";
	//set hidden input types so that whe the teacher wants to update the marks the PHP script will have
	//all the relevant information
	$newRow .= "<input type=\"hidden\" name=\"homework_id\" value=\"$homeworkID\">";
	$newRow .= "<input type=\"hidden\" name=\"pupil_id\" value=\"$pupilID\">";
	//if the pupil has submitted homework for this homework then add a link to newRow which will allow the teacher
	//to view/download the submitted file
	//also add a textbox where the teacher can view and update marks along with a submit button to commit those marks 
	//to the database
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

if (count($register) == 0) {
	echo "<h1>You have no pupils in this class!</h1>";
}

echo "</table>";


//function that will query a specified table for a value within a specified field and returns the results as an array
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