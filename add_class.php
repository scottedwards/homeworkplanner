<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Class</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/nav-bar.css">
	<link rel="stylesheet" type="text/css" href="css/add-class.css">
</head>
<body>
<?php 
	include("nav_bar.php");
	generateNavBar("add_class");
?>

<?php
//initialise connection to databse
$conn = new mysqli("localhost", "root", "root", "homework_planner");
if ($_SESSION['type'] ==  "pupil") {
	//if the user is of the type "pupil" then output a form which gives them a
	//an combo box with a list of all teachers to refine their search
	//iniitialie the variable output and make it an empty string
	//append HTML text to the variable output (.= means append)
	$output = "";
	$output .= "<div id=\"search-classes\">";
		$output .= "<form method=\"post\">";
			$output .= "<select name=\"teacherID\">";
			$output .= "<option value=\"\">Do not specify</option>";
				//get all teachers
				$getTeachersSql = "SELECT * FROM `teacher_table`";
				$teachers = $conn->query($getTeachersSql);
				//loop through all teachers that where selected by the above query
				while ($teacher = $teachers->fetch_assoc()) {
					//get the teacher username
					$teacherUsername = $teacher['username'];
					//andthe teacher name
					$teacherName = $teacher['name'];
					//add each teacher as an option for the select box
					$output .= "<option value=\"$teacherUsername\">$teacherName</option>";
				}
			$output .= "</select>";
			$output .= "<input type=\"submit\" name=\"findClass\" value=\"Find Classes\">";
		$output .= "</form>";
	$output .= "</div>";
	//output the variable output to the webpage
	echo "$output";
} elseif ($_SESSION['type'] == "teacher") {
	//if the user is of the type "teacher" then show them a form to create homework
	$output = "";
	$output .= "<div id=\"create-class\">";
		$output .= "<form method=\"post\">";
			$output .= "<input type=\"text\" name=\"name\" placeholder=\"Class Name\">";
			$output .= "<input type=\"text\" name=\"classID\" placeholder=\"Class ID e.g. MathsYrX\">";
			$output .= "<input type=\"submit\" name=\"createClass\" id=\"create-submit\" value=\"Create Class\">";
		$output .= "</form>";
	$output .= "</div>";
	//output the variable output to the webpage
	echo "$output";
}
?>

<div id="submit-results">
	<?php 
		if($_POST) {
			if (isset($_POST['findClass'])) {
				include("php/find_classes.php");
			} elseif(isset($_POST['createClass'])) {
				include("php/create_class.php");
			}
		}
	?>
</div>

</body>
</html>