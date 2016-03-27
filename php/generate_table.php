<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$username = $_SESSION['username'];
$type = $_SESSION['type'];
$conn = new mysqli("localhost", "root", "root", "homework_planner");

//get classes for the user
$classList = getClasses($username, $type, $conn);
//get homework for those classes
$homeworkList = getHomeworks($classList, $conn);

//genereate table
if (count($homeworkList) > 0) {
	echo "<table>";
	foreach ($homeworkList as $homework) {
		$class = getClassDetails($homework['class_id'], $conn);
		$teacher = getTeacherDetails($class['teacher_id'], $conn);

		$title = $homework['title'];
		$homeworkID = $homework['homework_id'];
		$subjectName = $class['name'];
		$teacherName = $teacher['name'];
		$description = $homework['description'];
		$dueDate = $homework['due_date'];
		$timeToGo = strtotime($dueDate) - time();

		$resources = getResources($homeworkID, $conn);

		$newRow = "";
		if ($timeToGo >= 0) {
			$newRow .= "<tr><td class=\"deadline-ahead\">";
		} else {
			$newRow .= "<tr><td class=\"deadline-passed\">";
		}
		
		$newRow .= "<h3 id=\"$homeworkID\">$subjectName - $title</h3>";
		$newRow .= "<p><i>$teacherName</i></p>";
		$newRow .= "<p>$description</p>";

		//get resources
		if ($resources) {
			$newRow .= "<p>";
			foreach ($resources as $resource) {
				$path = $resource;
				$fileName = (explode("/", $path))[5];
				$newRow .= " - ";
				$newRow .= "<a href=\"$path\" download>$fileName</a>";
				$newRow .= "<br>";
			}
			$newRow .= "</p>";
		}
		
		//check if due date has passed or if user has submitted
		if ($timeToGo >= 0) {
			$newRow .= "<p><b>$dueDate</b></p>";
			if ($type == "pupil") {
				$newRow .= "<button class=\"submit-homework\"><a href=\"submit_homework.php?homeworkID=$homeworkID\">Submit</a>";
			}			
		} else {
			$newRow .= "<p><b>Deadline has passed</b></p>";
		}

		if ($type == "teacher") {
			$newRow .="<button class=\"view-submition\"><a href=\"view_submitions.php?homeworkID=$homeworkID\">View Submitions</a>";
		}

		$newRow .= "</td></tr>";


		echo "$newRow";
	}

	echo "</table>";
} else {
	echo "<div id=\"no-homework\"><h1>You have no homework!</h1><p>You can add a class by navigating to the add class page above!</p></div>";
}


function getResources($homeworkID, $conn) {
	$tempArray = [];
	$getResourcesSql = "SELECT * FROM `homework_resources` WHERE (`homework_id`) = ('$homeworkID')";
	$resources = $conn->query($getResourcesSql);
	while ($resource = $resources->fetch_assoc()) {
		$tempArray[] = $resource['path'];
	}
	return $tempArray;
}

function getTeacherDetails($teacherID, $conn) {
	$getTeacherSql = "SELECT * FROM `teacher_table` WHERE (`username`) = ('$teacherID')";
	$teacher = $conn->query($getTeacherSql);
	return $teacher->fetch_assoc();
}

function getClassDetails($classID, $conn) {
	$getClassSql = "SELECT * FROM `class_table` WHERE (`class_id`) = ('$classID')";
	$class = $conn->query($getClassSql);
	return $class->fetch_assoc();
}

//get all classes the student/teacher belongs to
function getClasses($username, $type, $conn) {
	$tempArray = [];
	if ($type == "pupil") {
		$getPupilClassesSql = "SELECT `class_id` FROM `register` WHERE (`pupil_id`) = ('$username')";
		$classes = $conn->query($getPupilClassesSql);
		while ($class = $classes->fetch_assoc()) {
			$tempArray[] = $class['class_id']; 
		}
	}

	if ($type == "teacher") {
		$getTeacherClassesSql = "SELECT `class_id` FROM `class_table` WHERE (`teacher_id`) = ('$username')";
		$classes = $conn->query($getTeacherClassesSql);
		while ($class = $classes->fetch_assoc()) {
			$tempArray[] = $class['class_id'];
		}
	}

	return $tempArray;
}

function getHomeworks($classList, $conn) {
	$tempArray = [];
	foreach ($classList as $class) {
		$getHomeworksSql = "SELECT * FROM `homework_table` WHERE (`class_id`) = ('$class')";
		$homeworks = $conn->query($getHomeworksSql);
		while ($homework = $homeworks->fetch_assoc()) {
			$tempArray[] = $homework;
		}
	}

	return $tempArray;
}
?>