<?php 

func generateNavBar($pageName) {
	$user = $_SESSION['username'];
	$type = $_SESSION['type'];

	$navbar = "";
	$navbar .= "<div class=\"nav-bar\">";
	$navbar .= "<ul>";

	if ($pageName == "homework_viewer") {
		$navbar .= "<li class\"nav-active\"><a href=\"homework_viewer.php\">Home</a></li>";
	} else {
		$navbar .= "<li class\"nav\"><a href=\"homework_viewer.php\">Home</a></li>";
	}

	if ($pageName == "add_class") {
		$navbar .= "<li class\"nav-active\"><a href=\"add_class.php\">Add Class</a></li>";
	} else {
		$navbar .= "<li class\"nav\"><a href=\"add_class.php\">Add Class</a></li>";
	}

	if ($type == "teacher") {
		if ($pageName == "add_homework") {
			$navbar .= "<li class\"nav-active\"><a href=\"add_homework.php\">Add Homework</a></li>";
		} else {
			$navbar .= "<li class\"nav\"><a href=\"add_homework.php\">Add Homework</a></li>";
		}
	}

	echo "$navbar";
}

?>
