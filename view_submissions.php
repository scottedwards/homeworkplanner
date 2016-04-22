<?php
session_start();
?>
<?php 
	session_start();
	error_reporting(E_ALL);
	ini_set('display_errors', 1);
?>
<!DOCTYPE html>
<html>
<head>
	<title>Submissions</title>
	<link rel="stylesheet" type="text/css" href="css/nav-bar.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/view-submissions.css">
	<script type="text/javascript" src="js/jquery-2.2.1.min.js"></script>
	
	<script type="text/javascript" src="js/binary-tree.js"></script>
	<script type="text/javascript" src="js/sort-table.js"></script>
</head>
<body>
	<?php
	include("nav_bar.php");
	generateNavBar("other");
	?>
	<div id="homeworkTitle">
		<?php 
		//get the url of the website. this url contains a parameter of the homework ID of the submissions the teacher wants to see
		$url = $_SERVER['REQUEST_URI'];
		$homeworkID = explode("=", $url)[1];
		$conn = new mysqli("localhost", "root", "root", "homework_planner");
		$getRowSql = "SELECT * FROM `homework_table` WHERE (`homework_id`) = ('$homeworkID')";
		$results = $conn->query($getRowSql);
		while ($result = $results->fetch_assoc()) {
			$homeworkTitle = $result['title'];
			echo "<h1>- $homeworkTitle -</h1>";
		}
		?>
	</div>
	<div id="sort-buttons">
		<button id="sortByTitle" onclick="sortBy('title')">Sort By Pupil</button>
		<button id="sortByDueDate" onclick="sortBy('mark')">Sort By Mark</button>
	</div>
	<div id="errors">
		<?php include("php/update_marks.php") ?>
	</div>
	<table>
		<?php
		include("php/show_submissions.php");
		?>
	</table>
</body>
</html>