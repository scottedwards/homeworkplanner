<?php

if ($_POST) {
	$name = $_POST['name'];
	$username = $_POST['username'];
	$password = $_POST['password'];
	$repeatedPswd = $_POST['repeatedPassword'];
	$email = $_POST['email'];

	$conn = new mysqli("localhost", "root", "root", "homework_planner");

	//check what type they are
	if (isset($_POST['pupilSubmit'])) {
		$type = "pupil";
		$option = $_POST['year'];
	} elseif (isset($_POST['teacherSubmit'])) {
		$type = "teacher";
		$option = $_POST['subject'];
	}

	//validation
	$errmsg = [];

	//name
	if (!empty($name)) {
		if (strlen($name) < 35) {
			if (ctype_alpha(str_replace(' ', '', $name))) {
				$errmsg[] = "✓";
			} else {
				$errmsg[] = "« Your name can only contain letters";
			}
		} else {
			$errmsg[] = "« Your name is too long";
		}
	} else {
		$errmsg[] = "« Please enter a name";
	}

	//username
	if (!empty($username)) {
		if (strlen($username) < 20) {
			if (ctype_alnum($username)) {
				//check if username exists
				$table = $type ."_table";
				$checkUsernameSql = "SELECT * FROM `$table` WHERE (`username`) = ('$username')";
				$results = $conn->query($checkUsernameSql);
				if ($results->num_rows == 0) {
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

	//password
	if (!empty($password)) {
		if ($password == $repeatedPswd) {
			if (strlen($password) >= 5) {
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
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

	//optional entry
	if ($type == "pupil") {
		if (!empty($option)) {
			if (ctype_digit($option)) {
				if ($option >= 7 && $option <= 13) {
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
		if (!empty($option)) {
			if (strlen($option) <= 20) {
				if (ctype_alpha($option)) {
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

	//email
	if (!empty($email)) {
		if (strlen($email <= 50)) {
			$errmsg[] = "✓";
		} else {
			$errmsg[] = "« Your email is too long!";
		}
	} else {
		$errmsg[] = "« Please enter an email!";
	}


	//print errors
	$formCorrect = true;
	$errors ="<div class=\"errors\">";
	foreach ($errmsg as $error) {
		if ($error != "✓") {
			$formCorrect = false;
		}
		$errors .= "<p>$error</p>";
	}
	$errors .= "</div>";

	if ($formCorrect) {
		if ($type == "pupil") {
			$addNewUserSql = "INSERT INTO `pupil_table` (`username`, `password`, `name`, `email`, `year`) VALUES ('$username', '$hashedPassword', '$name', '$email', '$option')";
		} else {
			$addNewUserSql = "INSERT INTO `teacher_table` (`username`, `password`, `name`, `subject`, `email`) VALUES ('$username', '$hashedPassword', '$name', '$option', '$email')";
		}

		$conn->query($addNewUserSql);
		//maybe add some confirmation!!!!!!!!
	} else {
		echo "$errors";
	}
}
?>