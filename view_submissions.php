<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Submissions</title>
	<link rel="stylesheet" type="text/css" href="css/nav-bar.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="css/view-submissions.css">
</head>
<body>
<?php
include("nav_bar.php");
generateNavBar("other");
?>
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