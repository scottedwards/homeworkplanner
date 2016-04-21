<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Add Homework</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/nav-bar.css">
	<link rel="stylesheet" type="text/css" href="css/add-homework.css">
	<script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
</head>
<body>
<?php 
	include("nav_bar.php"); 
	generateNavBar("add_homework");
?>
<div id="form-holder">
	<form method="post" enctype="multipart/form-data">
		<input type="text" name="title" placeholder="Homework Title">
		<select name="classID">
		<option value="">Select a class:</option>
			<?php 
			//get username of the teacher
			$username = $_SESSION['username'];
			//initialise new database connection
			$conn = new mysqli("localhost", "root", "root", "homework_planner");
			$getClassesSql= "SELECT `class_id` FROM `class_table` WHERE (`teacher_id`) = ('$username')";
			//gets all classes that the teacher has
			$classes = $conn->query($getClassesSql);
			//for each class the teacher has, output an option 
			//with that class' ID as its value
			while ($class = $classes->fetch_assoc()) {
				$classID = $class['class_id'];
				$newOption = "<option value=\"$classID\">$classID</option>";
				echo "$newOption";
			}
			?>
		</select>
		<textarea type="text" name="description" placeholder="Description" cols="50" rows="5"></textarea>
		<?php 
		function createSelect($name, $min, $max) {
			echo "<select name=\"$name\">";
			for ($i = $min; $i <= $max; $i++) {
				//the conditional below add a "0" to the begging of the number as we want
				//the dates to be of the format yyyy-mm-dd
				//so the second of march 2016 should be 2016-03-02 not 2016-3-2
				if ($i < 10) {
					$value = "0$i";
				} else {
					$value = "$i";
				}
				$newOption = "<option value=\"$value\">$value</option>";
				echo "$newOption";
			}
			echo "</select>";
		}
		echo "<p>Year</p>";
		echo "<p>Month</p>";
		echo "<p>Day</p>";
		//date() is a PHP function that you can use with multiple parameters to get various time related information
		//here I have used the parameter "Y" to get the current year, and then use it again to get next years year
		createSelect("year", date("Y"), date("Y") + 1);
		createSelect("month", 1, 12);
		createSelect("day", 1, 31);
		?>
		<input type="file" name="filesToUpload[]" multiple>
		<input type="submit" name="createHomework" id="submit" value="Create Homework"></input>
	</form>
	<div id="form-msgs">
		<?php include "php/create_homework.php"; ?>
	</div>
</div>
</body>
</html>