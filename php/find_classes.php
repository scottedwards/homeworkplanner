<?php 
//initialise new connection to database
$conn = new mysqli("localhost", "root", "root", "homework_planner");
//get the username of the logged in user
$username = $_SESSION['username'];
//get the selected value from the combo-box from the find classes form
$teacherID = $_POST['teacherID'];
$classList = [];
//get all classes that belong to this teacher
if (empty($teacherID)) {
	//select all teachers
	$getClassesSql = "SELECT * FROM `class_table`";
} else {
	//select all classes from one specific teacher
	$getClassesSql = "SELECT * FROM `class_table` WHERE (`teacher_id`) = ('$teacherID')";
}

//add all rows returned from the query in classes to the array classList
$classes = $conn->query($getClassesSql);
while ($class = $classes->fetch_assoc()) {
	$classList[] = $class;
}

//now go through all the classes and remove any that the student is already enrolled in
$counter = 0;
foreach ($classList as &$class) {
	$classID = $class['class_id'];
	$checkIfEnrolledSql = "SELECT * FROM `register` WHERE (`class_id`, `pupil_id`) = ('$classID', '$username')";
	$results = $conn->query($checkIfEnrolledSql);
	if ($results->num_rows > 0) {
		unset($classList[$counter]);
	}
	//needed as otherwise in the next for-each loop the last data value is corrupted
	//after researching I found this is a known php bug #29992
	unset($class);
	$counter += 1;
}

//reshuffle this array as deleting classes from it in the previous loop will have left gaps
$classList = array_values($classList);
//print results
echo "<table id=\"class-table\">";
foreach ($classList as $class) {
	$className = $class['name'];
	$classID = $class['class_id'];
	$teacherID = $class['teacher_id'];

	$newRow = "";
	$newRow .= "<tr><td>";
		$newRow .= "<form method=\"post\" action=\"php/enroll_in_class.php\">";
			$newRow .= "<p><h3>$className</h3> - <h4>$teacherID</h4>";
			$newRow .= "<input type=\"hidden\" name=\"classID\" value=\"$classID\">";
			$newRow .= "<input type=\"submit\" name=\"enroll\" value=\"Enroll\">";
		$newRow .= "</form>";
	$newRow .= "</td></tr>";
	echo "$newRow";
}

echo "</table>";

?>