<?php 

function generateNavBar($pageName) {
	$user = $_SESSION['username'];
	$type = $_SESSION['type'];

	$navbar = "";
	$navbar .= "<div id=\"navbar\">";
		$navbar .= "<div class=\"container\">";
			$navbar .= "<div class=\"row\">";
				$navbar .= "<div class=\"col-md-4\">";
					$navbar .= "<ul class=\"nav nav-pills orange\">";

						if ($pageName == "homework_viewer") {
							$navbar .= "<li class=\"active\"><a href=\"#\">Home</a></li>";
						} else {
							$navbar .= "<li><a href=\"homework_viewer.php\">Home</a></li>";
						}

						if ($pageName == "add_class") {
							$navbar .= "<li class=\"active\"><a href=\"#\">Add Class</a></li>";
						} else {
							$navbar .= "<li><a href=\"add_class.php\">Add Class</a></li>";
						}

						if ($type == "teacher") {
							if ($pageName == "add_homework") {
								$navbar .= "<li class=\"active\"><a href=\"#\">Add Homework</a></li>";
							} else {
								$navbar .= "<li><a href=\"add_homework.php\">Add Homework</a></li>";
							}
						}

					$navbar .= "</ul>";
				$navbar .= "</div>";

				$navbar .= "<div id=\"username-box\" class=\"col-md-4\">";
					$navbar .= "<h4>$user</h4>";
				$navbar .= "</div>";

				$navbar .= "<div class=\"col-md-4\">";
					$navbar .= "<ul class=\"nav nav-pills\">";
						$navbar .= "<li id=\"log-out\"><a href=\"log_out.php\">Log Out</a></li>";
				$navbar .= "</div>";
			$navbar .= "</div>";
		$navbar .= "</div>";
	$navbar .= "</div>";

	echo "$navbar";
}

?>
