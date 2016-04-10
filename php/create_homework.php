<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);
if ($_POST) {
	$title = $_POST['title'];
	$classID = $_POST['classID'];
	$description = $_POST['description'];
	$files = $_FILES['filesToUpload'];

	$year = $_POST['year'];
	$month = $_POST['month'];
	$day = $_POST['day'];

	$errmsg = [];

	//validation
	//check to make sure the teacher has written down a title, that it doesnt exceed the field length
	//and that it only conatins letters, numbers and spaces
	if (!empty($title)) {
		if (strlen($title) <= 25) {
			if (!ctype_alnum(str_replace(" ", "", $title))) {
				$errmsg[] = "Your title can only have letters and numbers!";
			}
		} else {
			$errmsg[] = "Your title should be less than 25 characters long!";
		}
	} else {
		$errmsg[] = "Please enter a title!";
	}

	//check to make sure the teacher has selected a class, I gave the default option ('Select a class:') the value ''
	//so if the variable classID is empty I know the teacher hasnt selected a class
	if (empty($classID)) {
		$errmsg[] = "Please select a class!";
	}

	//check to make sure the description contains something and is shorter than the field length in the database
	if (!empty($description)) {
		$desclen = strlen($description);
		if ($desclen > 255) {
			$errmsg[] = "Your description ($desclen char. long) should be shorter than 255 characters";
		}
	} else {
		$errmsg[] = "Please enter a description!";
	}

	//check to make sure the date is valid, i.e no 31st of february, and that it's not in the past
	if (checkdate($month, $day, $year)) {
		$timeDifference = strtotime("$year-$month-$day") - time();
		if ($timeDifference > 0) {
			$dueDate = "$year-$month-$day";
		} else {
			$errmsg[] = "This date is in the past!";
		}
	} else {
		$errmsg[] = "Your date isn't valid!";
	}

	
echo "<table>";
	if (count($errmsg) > 0) {
		foreach ($errmsg as $error) {
			echo "<tr><td>$error<br></td></tr>";
		}
	} else {
		$conn = new mysqli("localhost", "root", "root", "homework_planner");
		$homeworkID = "$classID" .time();
		//add homework to database
		$addHomeworkSql = "INSERT INTO `homework_table` (`homework_id`, `class_id`, `title`, `description`, `due_date`) VALUES ('$homeworkID', '$classID', '$title', '$description', '$dueDate')";
		$conn->query($addHomeworkSql);
		//upload the files
		include("file_handler.php");
		uploadFiles($files, "resources", $homeworkID);

		echo "<tr><td>Homework Created!</td></tr>";
	}
echo "</table>";
}
?>