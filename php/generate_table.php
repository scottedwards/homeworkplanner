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
		//get class and teacher for this homework
		$class = getClassDetails($homework['class_id'], $conn);
		$teacher = getTeacherDetails($class['teacher_id'], $conn);
		//declare variables needed to present the homework
		$title = $homework['title'];
		$homeworkID = $homework['homework_id'];
		$className = $class['name'];
		$teacherName = $teacher['name'];
		$description = $homework['description'];
		$dueDate = $homework['due_date'];
		$timeToGo = strtotime($dueDate) - time();
		//get resources of this homework
		$resources = getResources($homeworkID, $conn);
		//delcare and initialise hasCompleted as false
		$hasCompleted = false;

		//start creating the row
		$newRow = "";
		$newRow .= "<tr><td dueDate=\"$dueDate\">";
		
		$newRow .= "<h3 id=\"$homeworkID\">$className  - $title</h3>";
		$newRow .= "<p><i>$teacherName</i></p>";
		$newRow .= "<p>$description</p>";

		//get resources
		if ($resources) {
			$newRow .= "<p>";
			//loop through each resource one by one
			foreach ($resources as $resource) {
				$path = $resource;
				//split the string "path" by any dashes into an array
				$splitPath = explode("/", $path);
				//the fileName = the last index in the array splitPath
				$fileName = $splitPath[count($splitPath) - 1];
				$newRow .= " - ";
				//add resource to the row as a link to the file
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
			//check to see if the pupil has submitted anything for this homework
			if ($results->num_rows > 0) {
				//set hasCompleted to true so we know to put the homework in the completed table
				$hasCompleted = true;
				//pupils can only submit one file per homeowork so i dont need to loop through results
				$submission = $results->fetch_assoc();
				$mark = $submission['mark'];
				//if the mark is empty i.e. = '' then tell the pupil that the teacher hasn't marked it yet
				if (empty($mark)) {
					$newRow .= "<p>You have submitted this but the teacher <b>hasn't marked it</b></p>";
				} else {
					//else give them their mark
					$newRow .= "<p>You got <b>$mark</b></p>";
				}
			} else {
				//check if due date has passed
				if ($timeToGo >= 0) {
					//if the due date hasnt passed show them the date and the button to submit their work
					$newRow .= "<p><b>$dueDate</b></p>";
					$newRow .= "<button class=\"submit-homework\"><a href=\"submit_homework.php?homeworkID=$homeworkID\">Submit</a></button>";
				} else {
					//if the deadline has passed then set the hasCompleted to true so it can go in the other table
					$hasCompleted = true;
					//tell them the deadline has passed
					$newRow .= "<p><b>Deadline has passed</b></p>";
				}
			}
		} elseif ($type == "teacher") {
			//however if they are a teacher then:
			if ($timeToGo >= 0) {
				//if the due date is still in the future then tell them the date
				$newRow .= "<p><b>$dueDate</b></p>";
			} else {
				//otherwise tell them its passed and set hasCompleted = true
				$hasCompleted = true;
				$newRow .= "<p><b>Deadline has passed</b></p>";
			}
			//print a "View Submissions" button regardless of due date
			$newRow .="<button class=\"view-submission\"><a href=\"view_submissions.php?homeworkID=$homeworkID\">View Submissions</a></button>";
		}
		
		

		$newRow .= "</td></tr>";

		//if the homework has been completed then add the row to passedHomeworkTable array
		if ($hasCompleted) {
			$passedHomeworkTable[] = $newRow;
		} else {
			//otherwise add it to dueHomeworkTable array
			$dueHomeworkTable[] = $newRow;
		}
	}

	//echo the tables

	echo "<div class=\"table-holder\">";
		echo "<h2>Due in:</h2>";
		echo "<table id=\"due-in\">";
		if (count($dueHomeworkTable) > 0) {
			//go through each homework in dueHomeworkTable and print each row
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
		//do the same for the passedHomeworkTable
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

//get all classes the student/teacher belongs to
function getClasses($username, $type, $conn) {
	//create new empty array
	$tempArray = [];
	if ($type == "pupil") {
		//if the user is a pupil then select all the rows in register that he belongs to
		//then get the classID from that row and add it to an array
		$getPupilClassesSql = "SELECT `class_id` FROM `register` WHERE (`pupil_id`) = ('$username')";
		$classes = $conn->query($getPupilClassesSql);
		while ($class = $classes->fetch_assoc()) {
			$tempArray[] = $class['class_id']; 
		}
	} else if ($type == "teacher") {
		//if they are a teacher then select all the classes from the class table where the teacher ID has their
		//username. Then go thorugh each row and add the classID to an array
		$getTeacherClassesSql = "SELECT `class_id` FROM `class_table` WHERE (`teacher_id`) = ('$username')";
		$classes = $conn->query($getTeacherClassesSql);
		while ($class = $classes->fetch_assoc()) {
			$tempArray[] = $class['class_id'];
		}
	}
	//return the array
	return $tempArray;
}

//gets a list of all the homeworks that belong to the lost of classes
function getHomeworks($classList, $conn) {
	$tempArray = [];
	//loop through each class and find any homeworks that belong to it in he homework table
	//then go through those homeworks and add them to a temporary array
	foreach ($classList as $class) {
		$getHomeworksSql = "SELECT * FROM `homework_table` WHERE (`class_id`) = ('$class')";
		$homeworks = $conn->query($getHomeworksSql);
		while ($homework = $homeworks->fetch_assoc()) {
			$tempArray[] = $homework;
		}
	}
	//return the array of homeworks
	return $tempArray;
}

//this gets the row that conatains the class details for the class with the specfied ID
function getClassDetails($classID, $conn) {
	$getClassSql = "SELECT * FROM `class_table` WHERE (`class_id`) = ('$classID')";
	//no need to loop through results as there is only one due to classID being the primary key
	$class = $conn->query($getClassSql);
	return $class->fetch_assoc();
}

//this function gets the details of a teacher specified by their ID
function getTeacherDetails($teacherID, $conn) {
	$getTeacherSql = "SELECT * FROM `teacher_table` WHERE (`username`) = ('$teacherID')";
	//teacher_id is also a primary key so no need to loop through various results
	$teacher = $conn->query($getTeacherSql);
	return $teacher->fetch_assoc();
}


//get all the resources for the specified homework and return them in an array
function getResources($homeworkID, $conn) {
	$tempArray = [];
	$getResourcesSql = "SELECT * FROM `homework_resources` WHERE (`homework_id`) = ('$homeworkID')";
	$resources = $conn->query($getResourcesSql);
	//loop thorugh each resource and add its path to the temporary array
	while ($resource = $resources->fetch_assoc()) {
		$tempArray[] = $resource['path'];
	}
	//return the array
	return $tempArray;
}
?>