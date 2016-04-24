<?php 
if ($_POST) {
	//initialise variables to store data from the POSTed form, the teachers username and create a database connection
	$username = $_SESSION['username'];
	$className = $_POST['name'];
	$classID = $_POST['classID'];
	$conn = new mysqli("localhost", "root", "root", "homework_planner");
	//create empty array to store error messages in
	$errmsg = [];

	//validation
	//class name
	if (!empty($className)) { //make sure class name is not empty
		//make sure $className is under 15 characters long
		if (strlen($className) > 15) {
			$errmsg[] = "Your class name must be less than 15 characters!";
		}
	} else {
		$errmsg[] = "Please enter a name for your class!";
	}

	//class ID
	if (!empty($classID)) {
		//make sure $classID is only made of letters and numbers (alnnum = alpha numeric)
		if (ctype_alnum($classID)) {
			if (strlen($classID) <= 15) { //make sure classID is less than 15 characters long
				//check class table to see if there is a class with ID = classID
				$checkClassIDSql = "SELECT * FROM `class_table` WHERE (`class_id`) = ('$classID')";
				$results = $conn->query($checkClassIDSql);
				//if the number of classes that already exists with this id is greater than 0...
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

	//if there are no erros in errmsg then create the class, else, output the errors
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
?>