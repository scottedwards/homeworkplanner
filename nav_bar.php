<?php 

function generateNavBar($pageName) {
	//get username and type from session stored variables
	$user = $_SESSION['username'];
	$type = $_SESSION['type'];

	//declare and initialse navbar as an empty string and start building the code
	$navbar = "";
	$navbar .= "<div id=\"navbar\">";
		$navbar .= "<div class=\"container\">";
			$navbar .= "<div class=\"row\">";
				//using bootstrap classes here, which make stuling a webpage easier (col-md-4) <- this tells the browser
				//to give the next container a collumn of width 4 out of 12 from the row above ^
				$navbar .= "<div class=\"col-md-4\">";
					$navbar .= "<ul class=\"nav nav-pills orange\">";

						//the follwing conditions check to see if the parameter passed equals any of ther pages that
						//will be displayed in the navigation bar. If it does equal one of them then that list item (li)
						//will have the class "active" and will show up orange. Any page that is not open will show up in the default
						//colours whihc are white
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
						//make sure the user is a teacher and if so then output the following. This is because pupils are not allowed
						//to create homeworks and so are not given the option to go to that page
						if ($type == "teacher") {
							if ($pageName == "add_homework") {
								$navbar .= "<li class=\"active\"><a href=\"#\">Add Homework</a></li>";
							} else {
								$navbar .= "<li><a href=\"add_homework.php\">Add Homework</a></li>";
							}
						}

					$navbar .= "</ul>";
				$navbar .= "</div>";

				//output the user's username in the middle of the nav bar so they can quicly checked who's logged in
				$navbar .= "<div id=\"username-box\" class=\"col-md-4\">";
					$navbar .= "<h4>$user</h4>";
				$navbar .= "</div>";

				//add a log out button
				$navbar .= "<div class=\"col-md-4\">";
					$navbar .= "<ul class=\"nav nav-pills\">";
						$navbar .= "<li id=\"log-out\"><a href=\"log_out.php\">Log Out</a></li>";
				$navbar .= "</div>";
			$navbar .= "</div>";
		$navbar .= "</div>";
	$navbar .= "</div>";
	//output the HTML code within the variable $navbar
	echo "$navbar";
}
?>
