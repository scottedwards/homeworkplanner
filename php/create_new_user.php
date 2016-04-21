<?php
//if data has been sent via POST from a form
if ($_POST) {
	//get all the variables needed from the POST data
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$repeatedPswd = $_POST['repeatedPassword'];
	$email = $_POST['email'];
	//initialise a new connection to the database
	$conn = new mysqli("localhost", "root", "root", "homework_planner");

	//check what type of user they are
	//and adjust variables accordingly
	if (isset($_POST['pupilSubmit'])) {
		$type = "pupil";
		$option = $_POST['year'];
	} elseif (isset($_POST['teacherSubmit'])) {
		$type = "teacher";
		$option = $_POST['subject'];
	}

	//declare and initialise a new empty array that will store all the error messages
	//we want to output to the user
	$errmsg = [];

	//validiate name
	if (!empty($name)) { //make sure its not empty
		if (strlen($name) < 35) { //make sure its under 35 characters
			if (ctype_alpha(str_replace(' ', '', $name))) { //make sure its only made of spaces and letters
				$errmsg[] = "✓"; //everything seems fine
			} else {
				$errmsg[] = "« Your name can only contain letters";
			}
		} else {
			$errmsg[] = "« Your name is too long";
		}
	} else {
		$errmsg[] = "« Please enter a name";
	}

	//validate username
	if (!empty($username)) { //make sure username is not empty
		if (strlen($username) < 20) { //make sure its unser 20 characters long
			if (ctype_alnum($username)) {
				//check if username exists
				$table = $type ."_table";
				$checkUsernameSql = "SELECT * FROM `$table` WHERE (`username`) = ('$username')";
				//get the rows of any user's in the table set above with the same username
				$results = $conn->query($checkUsernameSql);
				if ($results->num_rows == 0) {
					// as long as there aren't any other users with this username everything's fine
					$errmsg[] = "✓"; 	
				} else {
					$errmsg[] = "« This username already exists!";
				}
			} else {
				$errmsg[] = "« Your name can only contain letters and numbers";
			}
		} else {
			$errmsg[] = "« Your username is too long";
		}
	} else {
		$errmsg[] = "« Please enter a username";
	}

	//validate password
	if (!empty($password)) { //make sure password isn't empty
		if ($password == $repeatedPswd) { //check to see if they entered matching passwords
			if (strlen($password) >= 5) { //make sure its over 5 characters long
				//password_hash is a PHP function that hashes a string using a one way
				//hashing algorithm. The reason I have done this is for security reasons.
				//Now, if someone manages to get into my user database, they cannot know any of 
				//the passwords as the algorithm is one way
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
				//add two ticks as there are two password boxes
				$errmsg[] = "✓";
				$errmsg[] = "✓";
			} else {
				$errmsg[] = "« Your password should be at least 5 characters long!";
				$errmsg[] = "-";
			}
		} else {
			$errmsg[] = "« Your passwords do not match!";
			$errmsg[] = "-";
		}
	} else {
		$errmsg[] = "« Please enter a password!";
		$errmsg[] = "-";
	}

	//optional entry validation
	if ($type == "pupil") {
		//if the user wants to be a pupil
		if (!empty($option)) { //make sure its not empty
			if (ctype_digit($option)) { //make sure the year is an integer
				if ($option >= 7 && $option <= 13) { //make sure its inbetween 7 and 13
					$errmsg[] = "✓";
				} else {
					$errmsg[] = "« The year must be between 7 & 13";
				}
			} else {
				$errmsg[] = "« You can only have integers";
			}
		} else {
			$errmsg[] = "« Please enter a year!";
		}
	} elseif ($type == "teacher") {
		//if they want to be a teacher
		if (!empty($option)) { //make sure its not empty
			if (strlen($option) <= 20) { //make sure its under 20 characters long
				if (ctype_alpha($option)) { //make sure its only made of letters
					$errmsg[] = "✓";
				} else {
					$errmsg[] = "« Your subject can only contain letters";
				}
			} else {
				$errmsg[] = "« Your subject title is too long";
			}
		} else {
			$errmsg[] = "« Please enter a subject!";
		}
	}

	//email validation
	if (!empty($email)) { //make sure its not empty
		if (strlen($email <= 50)) { //makee sure the email is under 50 characters long
			//filter_var is another PHP function that "filters" a string with a 
			//specified filter, which in this case is the email filter. If the email
			//is of a valid format then it will return true
			if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
				$errmsg[] = "✓";
			} else {
				$errmsg[] = "« Invalid email format!";
			}			
		} else {
			$errmsg[] = "« Your email is too long!";
		}
	} else {
		$errmsg[] = "« Please enter an email!";
	}


	//declare fromCorrect and set it to true
	$formCorrect = true;
	//echo the beggiging of the html output
	$errors ="<div class=\"errors\">";
	//loop through each string in errmsg
	foreach ($errmsg as $error) {
		if ($error != "✓") {
			//if the error message doesn't equal ✓ then we know at least one
			//input is wring and so the form is incorrect
			$formCorrect = false;
		}
		$errors .= "<p>$error</p>";
	}
	$errors .= "</div>";

	//if all the fields where fine then add the user to the database!
	if ($formCorrect) {
		if ($type == "pupil") {
			//if they ant to be a pupil, add them to the pupil table
			$addNewUserSql = "INSERT INTO `pupil_table` (`username`, `password`, `name`, `email`, `year`) 
			VALUES ('$username', '$hashedPassword', '$name', '$email', '$option')";
		} else {
			//if they want to be a teacher, add them to the teacher table
			$addNewUserSql = "INSERT INTO `teacher_table` (`username`, `password`, `name`, `subject`, `email`) 
			VALUES ('$username', '$hashedPassword', '$name', '$option', '$email')";
		}
		//execute the query
		$conn->query($addNewUserSql);
	} else {
		//otherwise output the errors
		echo "$errors";
	}
}
?>