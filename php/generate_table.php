<?php
$username = $_SESSION['username'];
$type = $_SESSION['type'];
$conn = new mysqli("localhost", "root", "root", "homework_planner");

//get classes for the user
$classList = getClasses($username, $type, $conn);
//get homework for those classes
$homeworkList = getHomeworks($classList, $conn);
//create an array that will store the uncompleted homework
$dueHomeworkTable = [];
//create an array that will store the completed and passed homework
$passedHomeworkTable = [];

//genereate table
if (count($homeworkList) > 0) {
	//echo "<table id=\"homework-table\">";
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

		$hasCompleted = false;

		//start creating the row
		$newRow = "";
		$newRow .= "<tr><td dueDate=\"$dueDate\">";
		
		$newRow .= "<h3 id=\"$homeworkID\">$subjectName - $title</h3>";
		$newRow .= "<p><i>$teacherName</i></p>";
		$newRow .= "<p>$description</p>";

		//get resources
		if ($resources) {
			$newRow .= "<p>";
			foreach ($resources as $resource) {
				$path = $resource;
				$splitPath = explode("/", $path);
				$fileName = $splitPath[count($splitPath) - 1];
				$newRow .= " - ";
				$newRow .= "<a href=\"$path\" download>$fileName</a>";
				$newRow .= "<br>";
			}
			$newRow .= "</p>";
		}

		//check if its a pupil and if they have submitted the homework
		//else if they're a teacher say if the deadline has passed and give them a link where they can view submissions
		if ($type == "pupil") {
			$checkForSubmissionSql = "SELECT * FROM `homework_submissions` WHERE (`homework_id`, `pupil_id`) = ('$homeworkID', '$username')";
			$results = $conn->query($checkForSubmissionSql);
			if ($results->num_rows > 0) {
				//set hasCompleted to true so we know to put the homework in the completed table
				$hasCompleted = true;
				//pupils can only submit one file per homeowork so i dont need to loop through results
				$submission = $results->fetch_assoc();
				$mark = $submission['mark'];
				if (empty($mark)) {
					$newRow .= "<p>You have submitted this but the teacher <b>hasn't marked it</b></p>";
				} else {
					$newRow .= "<p>You got <b>$mark</b></p>";
				}
			} else {
				//check if due date has passed
				if ($timeToGo >= 0) {
					$newRow .= "<p><b>$dueDate</b></p>";
					$newRow .= "<button class=\"submit-homework\"><a href=\"submit_homework.php?homeworkID=$homeworkID\">Submit</a></button>";
				} else {
					$hasCompleted = true;
					$newRow .= "<p><b>Deadline has passed</b></p>";
				}
			}
		} elseif ($type == "teacher") {
			if ($timeToGo >= 0) {
				$newRow .= "<p><b>$dueDate</b></p>";
			} else {
				$hasCompleted = true;
				$newRow .= "<p><b>Deadline has passed</b></p>";
			}
			$newRow .="<button class=\"view-submition\"><a href=\"view_submissions.php?homeworkID=$homeworkID\">View Submissions</a></button>";
		}
		
		

		$newRow .= "</td></tr>";

		if ($hasCompleted) {
			$passedHomeworkTable[] = $newRow;
		} else {
			$dueHomeworkTable[] = $newRow;
		}
	}

	//echo the tables

	echo "<div class=\"table-holder\">";
		echo "<h2>Due in:</h2>";
		echo "<table id=\"due-in\">";
		if (count($dueHomeworkTable) > 0) {
			foreach ($dueHomeworkTable as $row) {
				echo "$row";
			}
		} else {
			echo "<h4>No homework due in!</h4>";
		}
		echo "</table>";
	echo "</div>";
	
	echo "<div class=\"table-holder\">";
		echo "<h2>Completed or deadline passed:</h2>";
		echo "<table id=\"passed-table\">";
			if (count($passedHomeworkTable) > 0) {
				foreach ($passedHomeworkTable as $row) {
					echo "$row";
				}
			} else {
				echo "No homework that has passed its due date!";
			}
		echo "</table>";
	echo "</div>";

	//echo "</table>";
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