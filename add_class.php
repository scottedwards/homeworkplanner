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
$conn = new mysqli("localhost", "root", "root", "homework_planner");
if ($_SESSION['type'] ==  "pupil") {
	$output = "";
	$output .= "<div id=\"search-classes\">";
		$output .= "<form method=\"post\">";
			$output .= "<select name=\"teacherID\">";
			$output .= "<option value=\"\">Do not specify</option>";
				//get teachers
				$getTeachersSql = "SELECT `username`, `name` FROM `teacher_table`";
				$teachers = $conn->query($getTeachersSql);
				while ($teacher = $teachers->fetch_assoc()) {
					$teacherUsername = $teacher['username'];
					$teacherName = $teacher['name'];
					$output .= "<option value=\"$teacherUsername\">$teacherName</option>";
				}
			$output .= "</select>";
			$output .= "<input type=\"submit\" name=\"findClass\" value=\"Find Classes\">";
		$output .= "</form>";
	$output .= "</div>";
	echo "$output";
} elseif ($_SESSION['type'] == "teacher") {
	$output = "";
	$output .= "<div id=\"create-class\">";
		$output .= "<form method=\"post\">";
			$output .= "<input type=\"text\" name=\"name\" placeholder=\"Class Name\">";
			$output .= "<input type=\"text\" name=\"classID\" placeholder=\"Class ID e.g. MathsYrX\">";
			$output .= "<input type=\"submit\" name=\"createClass\" id=\"create-submit\" value=\"Create Class\">";
		$output .= "</form>";
	$output .= "</div>";
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