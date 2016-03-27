<?php 
if ($_POST) {
	$username = $_SESSION['username'];
	$className = $_POST['name'];
	$classID = $_POST['classID'];
	$conn = new mysqli("localhost", "root", "root", "homework_planner");

	$errmsg = [];
		//validation
		//class name
	if (!empty($className)) {
		if (strlen($className > 15)) {
			$errmsg[] = "Your class name must be less than 15 characters!";
		}
	} else {
		$errmsg[] = "Please enter a name for your class!";
	}

	if (!empty($classID)) {
		if (ctype_alnum($classID)) {
			if (strlen($classID <= 15)) {
					//check to see if class id exists
				$checkClassIDSql = "SELECT * FROM `class_table` WHERE (`class_id`) = ('$classID')";
				$results = $conn->query($checkClassIDSql);
				if ($results->num_rows > 0) {
					$errmsg[] = "This class ID is already in use!";
				}
			} else {
				$errmsg[] = "Your class ID must be less than 15 characters";
			}
		} else {
			$errmsg[] = "Your class ID can only contain letters and numbers";
		}
	} else {
		$errmsg[] = "Please enter a class ID";
	}

	if (count($errmsg) == 0) {
		$createNewClassSql = "INSERT INTO `class_table` (`class_id`, `teacher_id`, `name`) VALUES ('$classID', '$username', '$className')";
		$conn->query($createNewClassSql);
		echo "<div id=\"class-creation-feedback\"><h2>Class Created!</h2></div>";
	} else {
		echo "<div id=\"class-creation-feedback\">";
		foreach ($errmsg as $error) {
			echo "<h2>$error</h2>";
		}
		echo "</div>";
	}
}

function myPrint($meh) {
	echo "<pre>";
	var_dump($meh);
	echo "</pre>";
}
?>