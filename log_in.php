<!DOCTYPE html>
<html>
<head>
	<title>Log In</title>
	<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
	<script type="text/javascript" src="js/jquery-2.2.1.min.js"></script>
	<link rel="stylesheet" type="text/css" href="css/log-in.css">

	<script type="text/javascript">
	$(document).ready(function() {
		var currentlyViewing = "";
  		$("a").click(function() {
			var targetDivID = $(this).attr("href");
			$(this).css("background-color", "white");
			$(this).css("color", "#006bb3");
			$(this).css("border", "none");
    		if (targetDivID == "#StudentForm") {
    			$(targetDivID).css("display", "block");
    			$("#TeacherForm").css("display", "none");

    			$("#teacherButton").css("background-color", "#006bb3");
    			$("#teacherButton").css("color", "white");

    			$("#teacherButton").css("border-bottom", "2px solid black");
    			$("#teacherButton").css("border-left", "2px solid black");
   			} else {
      			$(targetDivID).css("display", "block");
    			$("#StudentForm").css("display", "none");

    			$("#pupilButton").css("background-color", "#006bb3");
    			$("#pupilButton").css("color", "white");

    			$("#pupilButton").css("border-bottom", "2px solid black");
    			$("#pupilButton").css("border-right", "2px solid black");
    		}			
		})

	});
	</script>

</head>
<body>
<div class="logo">
	<h1><b>Digital</b> Homework Planner</h1>
</div>
<div id="formholder">
	<ul class="nav nav-tab nav-justified">
		<li><a id="pupilButton" href="#StudentForm">Student</a></li>
		<li><a id="teacherButton" href="#TeacherForm">Teacher</a></li>
	</ul>
	
	<div class="tab-content">
		<div id="StudentForm">
			<form method="post" action="php/user_login.php">
				<input type="text" name="username" id="username" placeholder="Pupil ID"></input>
				<input type="password" name="password" id="password" placeholder="Password"></input>
				<input type="submit" class="submit" value="Log In!" name="pupilSubmit"></input>
			</form>
		</div>

		<div id="TeacherForm">
			<form method="post" action="php/user_login.php">
				<input type="text" name="username" id="username" placeholder="Teacher ID"></input>
				<input type="password" name="password" id="password" placeholder="Password"></input>
				<input type="submit" class="submit" value="Log In!" name="teacherSubmit"></input>
			</form>
		</div>
	</div>
	
</div>
</body>
</html>