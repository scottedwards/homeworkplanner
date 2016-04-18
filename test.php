<?php
	$conn = new mysqli("localhost", "root", "root", "homework_planner");
	$teachers = $conn->query("SELECT * FROM `teacher_table`");
	$tempArray = [];
	while ($teacher = $teachers->fetch_assoc()) {
		$tempArray[] = $teacher;
	}
	
	echo "<pre>";
	var_dump($tempArray);
	echo "</pre>";
?>