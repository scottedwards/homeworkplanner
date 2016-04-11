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